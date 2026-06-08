<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('volunteers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->nullable()->constrained()->nullOnDelete();
            $table->string('full_name');
            $table->string('phone', 30);
            $table->string('email')->nullable();
            $table->string('role')->nullable();
            $table->string('shift')->nullable();
            $table->text('skills')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_confirmed')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('volunteers');
    }
};
