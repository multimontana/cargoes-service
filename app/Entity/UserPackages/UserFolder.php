<?php

namespace App\Entity\UserPackages;

use App\Entity\FolderPackages\Folder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class UserFolder extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'folder_id',
        'is_owner',
        'is_bookmark',
        'settings',
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
    public function folder(): BelongsTo
    {
        return $this->belongsTo(Folder::class, 'folder_id');
    }

    /**
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_folders', 'folder_id');
    }
}
