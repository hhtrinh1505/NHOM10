<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_create_recipes_table.php
public function up()
{
    Schema::create('recipes', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->string('image')->nullable();
        $table->text('description');
        $table->text('ingredients'); // Lưu nguyên liệu
        $table->text('steps'); // Lưu cách làm
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};
