<?php

namespace App\Entity\UserPackages;

use App\Entity\RoomPackages\Room;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class UserRoom extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'room_id',
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
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    /**
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_rooms', 'room_id');
    }
}
