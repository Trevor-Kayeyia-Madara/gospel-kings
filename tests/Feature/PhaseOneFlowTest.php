<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\EventCategory;
use App\Models\MpesaTransaction;
use App\Models\Payment;
use App\Models\Registration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PhaseOneFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_free_registration_issues_confirmed_ticket(): void
    {
        $event = Event::create([
            'event_category_id' => EventCategory::create(['name' => 'Concert', 'slug' => 'concert'])->id,
            'title' => 'Worship Night',
            'slug' => 'worship-night',
            'summary' => 'A worship event.',
            'venue' => 'Main Hall',
            'starts_at' => now()->addMonth(),
        ]);

        $response = $this->post(route('events.register.store', $event), [
            'full_name' => 'Grace Attendee',
            'phone' => '0712345678',
            'email' => 'grace@example.com',
        ]);

        $registration = Registration::first();

        $response->assertRedirect(route('events.registration.success', $registration));
        $this->assertSame('confirmed', $registration->status);
        $this->assertNotNull($registration->ticket);
    }

    public function test_successful_mpesa_callback_confirms_paid_registration(): void
    {
        $event = Event::create([
            'title' => 'Dine With The King',
            'slug' => 'dine-with-the-king',
            'summary' => 'Dinner.',
            'venue' => 'Nairobi',
            'starts_at' => now()->addMonth(),
        ]);

        $registration = Registration::create([
            'event_id' => $event->id,
            'registration_number' => 'DINEWI-26-0001',
            'full_name' => 'Paid Guest',
            'phone' => '254712345678',
            'registration_type' => 'paid',
            'status' => 'payment_pending',
        ]);

        $payment = Payment::create([
            'registration_id' => $registration->id,
            'amount' => 1,
            'status' => 'stk_requested',
        ]);

        MpesaTransaction::create([
            'payment_id' => $payment->id,
            'merchant_request_id' => 'merchant-1',
            'checkout_request_id' => 'checkout-1',
            'phone' => '254712345678',
            'amount' => 1,
            'status' => 'requested',
        ]);

        $this->postJson(route('api.mpesa.callback'), [
            'Body' => [
                'stkCallback' => [
                    'MerchantRequestID' => 'merchant-1',
                    'CheckoutRequestID' => 'checkout-1',
                    'ResultCode' => 0,
                    'ResultDesc' => 'Success',
                    'CallbackMetadata' => [
                        'Item' => [
                            ['Name' => 'Amount', 'Value' => 1],
                            ['Name' => 'MpesaReceiptNumber', 'Value' => 'QATEST123'],
                            ['Name' => 'PhoneNumber', 'Value' => 254712345678],
                        ],
                    ],
                ],
            ],
        ])->assertOk()->assertJson(['ResultCode' => 0]);

        $this->assertSame('confirmed', $registration->fresh()->status);
        $this->assertSame('completed', $payment->fresh()->status);
        $this->assertSame('QATEST123', $payment->fresh()->receipt_number);
    }
}
