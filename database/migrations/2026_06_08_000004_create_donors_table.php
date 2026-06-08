<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->nullable()->constrained()->nullOnDelete();
            $table->string('full_name');
            $table->string('phone', 30);
            $table->string('email')->nullable();
            $table->string('donation_type')->nullable();
            $table->decimal('amount', 12, 2)->nullable();
            $table->string('payment_method')->default('mpesa');
            $table->string('status')->default('pending');
            $table->text('notes')->nullable();
            $table->boolean('is_anonymous')->default(false);
            $table->boolean('is_public')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donors');
    }
};
