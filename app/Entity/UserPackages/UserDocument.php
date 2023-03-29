<?php

namespace App\Entity\UserPackages;

use App\Entity\DocumentPackages\Document;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Testing\Fluent\Concerns\Has;

class UserDocument extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'document_id',
        'is_owner',
        'is_bookmark',
        'status',
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
    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class, 'document_id');
    }

    /**
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_documents', 'document_id');
    }
}
