<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ticket_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();

            $table->string('name'); // VIP, Standard, Free
            $table->boolean('is_free')->default(false);

            // store in smallest unit (e.g. cents)
            $table->unsignedInteger('price_amount')->default(0);
            $table->string('currency', 3)->default('MAD');

            $table->unsignedInteger('max_per_order')->nullable();

            $table->dateTime('sales_starts_at')->nullable();
            $table->dateTime('sales_ends_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ticket_types');
    }
};
