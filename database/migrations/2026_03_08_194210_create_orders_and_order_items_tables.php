<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();

            $table->foreignId('buyer_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('buyer_email');
            $table->string('buyer_phone')->nullable();

            $table->string('status')->default('pending'); // pending|paid|cancelled|expired|refunded

            $table->unsignedInteger('subtotal_amount')->default(0);
            $table->unsignedInteger('discount_amount')->default(0);
            $table->unsignedInteger('total_amount')->default(0);
            $table->string('currency', 3)->default('MAD');

            $table->string('payment_provider')->nullable(); // stripe, paypal, cmi, fake...
            $table->string('payment_reference')->nullable();

            $table->timestamps();

            $table->index(['event_id', 'status']);
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('ticket_type_id')->constrained()->cascadeOnDelete();
            $table->foreignId('seat_id')->nullable()->constrained('seats')->nullOnDelete();

            $table->unsignedInteger('unit_price_amount')->default(0);
            $table->unsignedInteger('qty')->default(1);

            $table->timestamps();

            $table->index(['seat_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};
