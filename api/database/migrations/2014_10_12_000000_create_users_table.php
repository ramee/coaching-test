<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\User\Domain\RoleEnum;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', static function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('role')->default(RoleEnum::Member->value);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
