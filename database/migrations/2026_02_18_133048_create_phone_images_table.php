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
        Schema::create('phone_images', function (Blueprint $table) {
            $table->id();

            // Связь с телефоном
            $table->foreignId('phone_id')->constrained()->onDelete('cascade');

            // Связь с вариацией (nullable, если изображение для всей модели)
            $table->foreignId('variant_id')->nullable()->constrained('phone_variants')->onDelete('cascade');

            // Путь к изображению
            $table->string('path')->unique();

            // Основное изображение
            // true → основное для вариации (если variant_id указан)
            // false → обычное
            // null → основное для всей модели (если variant_id = null)
            $table->boolean('is_main')->nullable()->default(null);

            $table->timestamps();

            // Индексы для быстрых выборок
            $table->index('phone_id');
            $table->index('variant_id');
            $table->index(['phone_id', 'is_main']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phone_images');
    }
};
