<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_item_id')->constrained()->cascadeOnDelete();

            $table->string('ticket_code')->unique();

            // Named ticket holder
            $table->string('holder_first_name');
            $table->string('holder_last_name')->nullable();
            $table->string('holder_email')->nullable();
            $table->string('holder_phone')->nullable();
            $table->string('holder_national_id')->nullable();

            // QR data
            $table->longText('qr_payload_json');
            $table->string('qr_signature'); // hex or base64, your choice (we'll standardize)

            // generated artifacts
            $table->string('pdf_path')->nullable();

            $table->timestamps();
        });

        Schema::create('check_ins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained()->cascadeOnDelete();
            $table->foreignId('checked_in_by_user_id')->nullable()->constrained('users')->nullOnDelete();

            $table->dateTime('checked_in_at');
            $table->boolean('is_manual_override')->default(false);
            $table->string('override_reason')->nullable();

            $table->timestamps();

            $table->unique('ticket_id'); // one check-in per ticket
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('check_ins');
        Schema::dropIfExists('tickets');
    }
};
