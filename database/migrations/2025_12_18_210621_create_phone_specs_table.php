<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('phone_specs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('phone_id')->constrained()->onDelete('cascade');

            // Основное

            $table->string('os')->nullable();
            $table->string('os_version')->nullable();
            $table->string('cpu_model')->nullable();
            $table->decimal('screen_size', 3, 1)->nullable();
            $table->tinyInteger('sim_count')->nullable();
            $table->string('sim_format')->nullable();
            $table->string('main_cam_resolution')->nullable();
            $table->integer('battery_capacity')->nullable();
            $table->string('charging_features')->nullable();
            $table->json('extra_specs')->nullable();

            $table->timestamps();
            $table->index('phone_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('phone_specs');
    }
};
