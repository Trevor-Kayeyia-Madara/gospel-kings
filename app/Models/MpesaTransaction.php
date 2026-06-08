<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MpesaTransaction extends Model
{
    protected $fillable = [
        'payment_id',
        'merchant_request_id',
        'checkout_request_id',
        'mpesa_receipt_number',
        'phone',
        'amount',
        'status',
        'request_payload',
        'callback_payload',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'request_payload' => 'array',
            'callback_payload' => 'array',
        ];
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }
}
