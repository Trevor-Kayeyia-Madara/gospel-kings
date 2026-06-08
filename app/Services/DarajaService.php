<?php

namespace App\Services;

use App\Models\Payment;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class DarajaService
{
    public function accessToken(): string
    {
        return Cache::remember('daraja_access_token', 3300, function () {
            $response = Http::withBasicAuth(
                (string) config('daraja.consumer_key'),
                (string) config('daraja.consumer_secret'),
            )->get(config('daraja.base_url').'/oauth/v1/generate', [
                'grant_type' => 'client_credentials',
            ]);

            $response->throw();

            return (string) $response->json('access_token');
        });
    }

    public function stkPush(Payment $payment): array
    {
        $payment->loadMissing('registration.event');

        $timestamp = now()->format('YmdHis');
        $shortCode = (string) config('daraja.business_short_code');
        $password = base64_encode($shortCode.config('daraja.passkey').$timestamp);
        $phone = $this->normalizePhone($payment->registration->phone);

        $payload = [
            'BusinessShortCode' => $shortCode,
            'Password' => $password,
            'Timestamp' => $timestamp,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => (int) ceil((float) $payment->amount),
            'PartyA' => $phone,
            'PartyB' => $shortCode,
            'PhoneNumber' => $phone,
            'CallBackURL' => config('daraja.callback_url'),
            'AccountReference' => Str::limit($payment->registration->registration_number, 12, ''),
            'TransactionDesc' => Str::limit($payment->registration->event->title, 40, ''),
        ];

        $response = Http::withToken($this->accessToken())
            ->acceptJson()
            ->post(config('daraja.base_url').'/mpesa/stkpush/v1/processrequest', $payload);

        $data = $response->json() ?? ['raw_response' => $response->body()];

        $payment->mpesaTransactions()->create([
            'merchant_request_id' => $data['MerchantRequestID'] ?? null,
            'checkout_request_id' => $data['CheckoutRequestID'] ?? null,
            'phone' => $phone,
            'amount' => $payload['Amount'],
            'status' => $response->successful() && isset($data['CheckoutRequestID']) ? 'requested' : 'failed',
            'request_payload' => [
                'request' => collect($payload)->except('Password')->all(),
                'response' => $data,
            ],
        ]);

        if ($response->successful() && isset($data['CheckoutRequestID'])) {
            $payment->update(['status' => 'stk_requested', 'metadata' => $data]);
        } else {
            $payment->update(['status' => 'failed', 'metadata' => $data]);
        }

        return $data;
    }

    public function query(Payment $payment): Response
    {
        $transaction = $payment->mpesaTransactions()->latest()->firstOrFail();
        $timestamp = now()->format('YmdHis');
        $shortCode = (string) config('daraja.business_short_code');

        return Http::withToken($this->accessToken())
            ->acceptJson()
            ->post(config('daraja.base_url').'/mpesa/stkpushquery/v1/query', [
                'BusinessShortCode' => $shortCode,
                'Password' => base64_encode($shortCode.config('daraja.passkey').$timestamp),
                'Timestamp' => $timestamp,
                'CheckoutRequestID' => $transaction->checkout_request_id,
            ]);
    }

    public function normalizePhone(string $phone): string
    {
        $digits = preg_replace('/\D+/', '', $phone) ?? '';

        if (Str::startsWith($digits, '0')) {
            return '254'.substr($digits, 1);
        }

        if (Str::startsWith($digits, '7') || Str::startsWith($digits, '1')) {
            return '254'.$digits;
        }

        return $digits;
    }
}
