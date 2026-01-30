<?php

namespace App\Models;

use App\Models\Interfaces\Ownerable;
use Database\Factories\TaskFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $user_id
 * @property string $description
 * @property int $priority
 * @property bool $status
 * @property-read User $user
 */
class Task extends Model implements Ownerable
{
    /** @use HasFactory<TaskFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'description',
        'priority',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getOwner(): User
    {
        return $this->user;
    }
}
