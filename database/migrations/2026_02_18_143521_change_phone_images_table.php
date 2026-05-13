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
        Schema::table('phone_images', function (Blueprint $table) {
            $table->unique(['phone_id', 'path'], 'img_phone_unique');
            $table->unique(['variant_id', 'path'], 'img_variant_unique');
        });
    }

    public function down(): void
    {
        Schema::table('phone_images', function (Blueprint $table) {
            $table->dropUnique('img_phone_unique');
            $table->dropUnique('img_variant_unique');
        });
    }
};
