<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('studio_id')->constrained('studios')->onDelete('cascade');
            $table->string('row', 2); // A-H
            $table->integer('number'); // 1-8
            $table->string('type', 50)->default('regular'); // regular, vip, couple
            $table->boolean('is_available')->default(true);
            $table->boolean('is_maintenance')->default(false);
            $table->timestamps();
            
            $table->unique(['studio_id', 'row', 'number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seats');
    }
};