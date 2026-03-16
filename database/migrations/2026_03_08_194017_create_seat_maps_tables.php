<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('seat_maps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->string('name')->default('Main');
            $table->unsignedInteger('grid_cols')->default(60);
            $table->unsignedInteger('grid_rows')->default(40);
            $table->timestamps();

            $table->unique(['event_id', 'name']);
        });

        Schema::create('seat_zones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seat_map_id')->constrained()->cascadeOnDelete();
            $table->foreignId('ticket_type_id')->nullable()->constrained()->nullOnDelete();

            $table->string('name'); // "VIP Zone A"
            $table->string('color')->nullable(); // hex for UI

            $table->timestamps();
        });

        Schema::create('seat_rows', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seat_zone_id')->constrained()->cascadeOnDelete();

            $table->string('label'); // e.g. A, B, C
            $table->unsignedInteger('sort_order')->default(0);

            $table->timestamps();
            $table->unique(['seat_zone_id', 'label']);
        });

        Schema::create('seats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seat_row_id')->constrained()->cascadeOnDelete();

            // grid position
            $table->unsignedInteger('grid_x');
            $table->unsignedInteger('grid_y');

            $table->string('label'); // e.g. "A-12" or "12"
            $table->boolean('is_accessible_pmr')->default(false);
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->unique(['seat_row_id', 'label']);
            $table->index(['grid_x', 'grid_y']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seats');
        Schema::dropIfExists('seat_rows');
        Schema::dropIfExists('seat_zones');
        Schema::dropIfExists('seat_maps');
    }
};
