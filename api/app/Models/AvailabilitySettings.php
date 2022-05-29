<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $id
 * @property string $user_id
 * @property string $availabilities
 * @property bool $is_recurring
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class AvailabilitySettings extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;

    protected $casts = [
        'is_recurring' => 'bool',
    ];
}
