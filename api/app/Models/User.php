<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $id
 * @property string $name
 * @property string $role
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class User extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;
}
