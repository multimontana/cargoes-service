<?php

namespace App\Entity\UserPackages;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $guard_name = 'api';

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'information'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'information' => 'array'
    ];
}
