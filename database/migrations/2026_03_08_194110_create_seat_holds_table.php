<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('seat_holds', function (Blueprint $table) {
            $table->id();

            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('seat_id')->constrained('seats')->cascadeOnDelete();

            $table->uuid('hold_token'); // ties many seats to one checkout attempt

            // who is holding
            $table->foreignId('held_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('held_by_session_id')->nullable();

            $table->dateTime('expires_at');

            $table->timestamps();

            $table->index(['event_id', 'expires_at']);
            $table->index(['hold_token']);
            $table->index(['seat_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seat_holds');
    }
};
