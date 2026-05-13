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
        Schema::create('phone_variants', function (Blueprint $table) {
            $table->id();

            $table->foreignId('phone_id')
                ->constrained('phones')
                ->cascadeOnDelete();

            $table->string('color');
            $table->unsignedSmallInteger('storage'); // ГБ
            $table->unsignedSmallInteger('ram');
            $table->decimal('price', 10, 2);

            $table->string('availability'); // in_stock, preorder, out_of_stock
            $table->string('delivery_time');

            $table->timestamps();
            $table->unique(['phone_id', 'color', 'storage', 'ram']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phone_variants');
    }
};
