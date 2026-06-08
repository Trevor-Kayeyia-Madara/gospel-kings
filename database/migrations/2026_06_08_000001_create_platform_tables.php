<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('label');
            $table->timestamps();
        });

        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('label');
            $table->timestamps();
        });

        Schema::create('event_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('edition')->nullable();
            $table->string('theme')->nullable();
            $table->text('summary');
            $table->longText('description')->nullable();
            $table->string('venue');
            $table->string('city')->nullable();
            $table->dateTime('starts_at');
            $table->dateTime('ends_at')->nullable();
            $table->unsignedInteger('capacity')->nullable();
            $table->boolean('is_paid')->default(false);
            $table->boolean('registration_open')->default(true);
            $table->decimal('base_price', 12, 2)->default(0);
            $table->string('banner_image')->nullable();
            $table->json('schedule')->nullable();
            $table->timestamps();
        });

        Schema::create('vip_packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('amount', 12, 2);
            $table->unsignedInteger('capacity')->nullable();
            $table->json('benefits')->nullable();
            $table->timestamps();
        });

        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('vip_package_id')->nullable()->constrained()->nullOnDelete();
            $table->string('registration_number')->unique();
            $table->string('full_name');
            $table->string('phone', 30);
            $table->string('email')->nullable();
            $table->string('church')->nullable();
            $table->string('county_city')->nullable();
            $table->string('gender')->nullable();
            $table->string('registration_type')->default('free');
            $table->string('status')->default('pending');
            $table->timestamps();
        });

        Schema::create('registration_tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_id')->constrained()->cascadeOnDelete();
            $table->string('ticket_number')->unique();
            $table->string('qr_payload')->unique();
            $table->dateTime('issued_at')->nullable();
            $table->dateTime('checked_in_at')->nullable();
            $table->timestamps();
        });

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_id')->constrained()->cascadeOnDelete();
            $table->decimal('amount', 12, 2);
            $table->string('method')->default('mpesa');
            $table->string('status')->default('pending');
            $table->string('receipt_number')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
        });

        Schema::create('mpesa_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_id')->nullable()->constrained()->nullOnDelete();
            $table->string('merchant_request_id')->nullable();
            $table->string('checkout_request_id')->nullable();
            $table->string('mpesa_receipt_number')->nullable();
            $table->string('phone', 30);
            $table->decimal('amount', 12, 2);
            $table->string('status')->default('pending');
            $table->json('request_payload')->nullable();
            $table->json('callback_payload')->nullable();
            $table->timestamps();
        });

        Schema::create('guest_ministers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('role')->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('email')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_public')->default(false);
            $table->timestamps();
        });

        Schema::create('sponsors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('tier')->nullable();
            $table->string('logo_path')->nullable();
            $table->decimal('pledged_amount', 12, 2)->nullable();
            $table->decimal('received_amount', 12, 2)->nullable();
            $table->boolean('is_public')->default(true);
            $table->timestamps();
        });

        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('media_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gallery_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->string('type')->default('photo');
            $table->string('path');
            $table->string('thumbnail_path')->nullable();
            $table->timestamps();
        });

        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('body');
            $table->dateTime('published_at')->nullable();
            $table->timestamps();
        });

        Schema::create('attendance_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('registration_ticket_id')->constrained()->cascadeOnDelete();
            $table->foreignId('checked_in_by')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('checked_in_at');
            $table->string('entry_point')->nullable();
            $table->timestamps();
        });

        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('action');
            $table->string('auditable_type')->nullable();
            $table->unsignedBigInteger('auditable_id')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
        Schema::dropIfExists('attendance_logs');
        Schema::dropIfExists('announcements');
        Schema::dropIfExists('media_files');
        Schema::dropIfExists('galleries');
        Schema::dropIfExists('sponsors');
        Schema::dropIfExists('guest_ministers');
        Schema::dropIfExists('mpesa_transactions');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('registration_tickets');
        Schema::dropIfExists('registrations');
        Schema::dropIfExists('vip_packages');
        Schema::dropIfExists('events');
        Schema::dropIfExists('event_categories');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('roles');
    }
};
