<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Domain\RoleEnum;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'role',
    ];

    protected $casts = [
        'role' => RoleEnum::class,
    ];
}
