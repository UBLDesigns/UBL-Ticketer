<?php

namespace App\Models;

use App\Models\Task;
use App\Models\User;
use App\Models\Reply;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'images', 'priority', 'status', 'option', 'user_id'];

    public function users(): BelongsTo
    {
        return $this->BelongsTo(User::class);
    }

    public function replies(): HasMany
    {
        return $this->hasMany(Reply::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}
