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
        Schema::table('reviews', function (Blueprint $table) {

            // Связь с пользователем (nullable для парсенных отзывов)
            $table->foreignId('user_id')
                ->nullable()
                ->after('phone_id')
                ->constrained()
                ->nullOnDelete();

            // Рейтинг 1–5
            $table->unsignedTinyInteger('rating')
                ->nullable()
                ->after('user_id');

            // Дата публикации
            $table->timestamp('published_at')
                ->nullable()
                ->after('content');

            // Индексы
            $table->index('user_id');
            $table->index('rating');

            // Ограничение: один пользователь — один отзыв на телефон
            $table->unique(
                ['phone_id', 'user_id'],
                'review_user_phone_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['rating']);
            $table->dropUnique('review_user_phone_unique');

            $table->dropConstrainedForeignId('user_id');
            $table->dropColumn('rating');
            $table->dropColumn('published_at');
        });
    }
};
