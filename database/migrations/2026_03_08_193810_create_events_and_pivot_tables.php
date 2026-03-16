<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();

            $table->foreignId('organizer_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('venue_id')->nullable()->constrained()->nullOnDelete();

            $table->string('title');
            $table->longText('description_html')->nullable(); // WYSIWYG output

            $table->string('timezone')->default('Africa/Casablanca');
            $table->dateTimeTz('starts_at');
            $table->dateTimeTz('ends_at');

            $table->string('status')->default('draft'); // draft|published|cancelled|archived

            $table->string('seo_slug')->unique();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();

            $table->string('cover_image_path')->nullable();
            $table->string('banner_image_path')->nullable();

            $table->timestamps();
            $table->index(['status', 'starts_at']);
            $table->index(['organizer_id', 'status']);
        });

        Schema::create('event_category', function (Blueprint $table) {
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->primary(['event_id', 'category_id']);
        });

        Schema::create('event_tag', function (Blueprint $table) {
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tag_id')->constrained()->cascadeOnDelete();
            $table->primary(['event_id', 'tag_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_tag');
        Schema::dropIfExists('event_category');
        Schema::dropIfExists('events');
    }
};
