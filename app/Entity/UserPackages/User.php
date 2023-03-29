<?php

namespace App\Entity\UserPackages;

use App\Entity\DocumentPackages\Document;
use App\Entity\Query;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use HasRoles;

    /**
     * @var string
     */
    protected $guard_name = 'api';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'surname',
        'image',
        'email',
        'email_code',
        'password',
        'email_password',
        'login_password',
        'tariff',
        'color',
        'country',
        'blocked',
        'google_id',
        'google_access_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'email_password',
        'login_password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'tariff' => 'array'
    ];

    /**
     * Boot
     */
    protected static function boot()
    {
        parent::boot();
        static::saving(function ($model) {
            $model->email = strtolower($model->email);
        });
        static::updating(function ($model) {
            $model->email = strtolower($model->email);
        });
    }

    /**
     * @return string|null
     */
    public function getEmailPassword(): ?string
    {
        return $this->email_password;
    }

    /**
     * @return string|null
     */
    public function getLoginPassword(): ?string
    {
        return $this->login_password;
    }

    /**
     * @return HasMany
     */
    public function documents(): HasMany
    {
        return $this->hasMany(UserDocument::class, 'user_id');
    }

    /**
     * @return BelongsToMany
     */
    public function directDocuments(): BelongsToMany
    {
        return $this->belongsToMany(Document::class, 'user_documents');
    }

    /**
     * @return hasMany
     */
    public function userProjects(): hasMany
    {
        return $this->hasMany(UserProject::class, 'user_id');
    }

    /**
     * @return HasMany
     */
    public function folders(): HasMany
    {
        return $this->hasMany(UserFolder::class, 'user_id');
    }

    /**
     * @return HasMany
     */
    public function projects(): HasMany
    {
        return $this->hasMany(UserProject::class, 'user_id');
    }

    /**
     * @return HasMany
     */
    public function rooms(): HasMany
    {
        return $this->hasMany(UserRoom::class, 'user_id');
    }

    /**
     * @return HasMany
     */
    public function workInProgressDocuments(): HasMany
    {
        return $this->hasMany(UserDocument::class, 'user_id')
            ->orderBy('created_at', Query::DESC)
            ->limit(8);
    }
}
