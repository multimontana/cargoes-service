<?php

namespace App\Entity\UserPackages;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    use HasFactory;

    /**
     * @var bool
     */
    public $timestamps = false;
    public $incrementing = false;
    public $primaryKey = false;

    /**
     * @var array
     */
    protected $fillable = [
        'email',
        'token',
        'created_at'
    ];
}
