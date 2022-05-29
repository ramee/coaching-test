<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('availability_settings', static function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->json('availabilities');
            $table->boolean('is_recurring');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('availability_settings');
    }
};
