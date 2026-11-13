<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('films', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('genre');
            $table->integer('duration'); // in minutes
            $table->decimal('rating', 3, 1)->default(8.0);
            $table->string('age_rating', 10)->default('SU');
            $table->string('director')->nullable();
            $table->text('cast')->nullable();
            $table->text('synopsis');
            $table->string('poster_url', 500);
            $table->string('banner_url', 500);
            $table->string('trailer_url', 500)->nullable();
            $table->enum('status', ['now_showing', 'upcoming'])->default('now_showing');
            $table->date('release_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('films');
    }
};
