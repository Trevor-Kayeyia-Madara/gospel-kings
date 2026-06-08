<?php

namespace App\Http\Controllers;

use App\Models\MpesaTransaction;
use App\Models\Payment;
use App\Services\DarajaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MpesaController extends Controller
{
    public function callback(Request $request): JsonResponse
    {
        $payload = $request->json()->all();
        $callback = data_get($payload, 'Body.stkCallback', []);
        $checkoutRequestId = $callback['CheckoutRequestID'] ?? null;

        $transaction = MpesaTransaction::where('checkout_request_id', $checkoutRequestId)->latest()->first();

        if ($transaction) {
            $resultCode = (int) ($callback['ResultCode'] ?? -1);
            $items = collect(data_get($callback, 'CallbackMetadata.Item', []))->keyBy('Name');
            $receipt = data_get($items->get('MpesaReceiptNumber'), 'Value');

            $transaction->update([
                'mpesa_receipt_number' => $receipt,
                'status' => $resultCode === 0 ? 'completed' : 'failed',
                'callback_payload' => $payload,
            ]);

            $payment = $transaction->payment;
            $payment?->update([
                'status' => $resultCode === 0 ? 'completed' : 'failed',
                'receipt_number' => $receipt,
                'metadata' => $payload,
            ]);

            if ($resultCode === 0) {
                $payment?->registration?->update(['status' => 'confirmed']);
            }
        }

        return response()->json(['ResultCode' => 0, 'ResultDesc' => 'Accepted']);
    }

    public function query(Payment $payment, DarajaService $daraja): JsonResponse
    {
        $response = $daraja->query($payment);
        $data = $response->json() ?? ['raw_response' => $response->body()];

        $payment->update(['metadata' => array_merge($payment->metadata ?? [], ['latest_query' => $data])]);

        return response()->json($data, $response->status());
    }
}
