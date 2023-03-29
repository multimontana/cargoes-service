<?php

namespace App\Entity\UserPackages;

use App\Entity\ProjectPackages\Project;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class UserProject extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'project_id',
        'is_owner',
        'is_bookmark',
        'settings',
        'role_name',
        'deleted_at'
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'settings' => 'array'
    ];

    /**
     * @return BelongsTo
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    /**
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_projects', 'user_id');
    }
}
