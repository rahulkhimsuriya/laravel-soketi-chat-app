<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property User sender
 * @property User receiver
 */
class Chat extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function scopeSendOrReceivedBy(
        Builder $builder,
        Authenticatable|User $user
    ): Builder {
        return $builder
            ->where(function (Builder $query)  use ($user) {
                return $query
                    ->where('sender_id', '=', $user->id)
                    ->orWhere('receiver_id', '=', $user->id);
            });
    }

    public function scopeChatHistoryFor(
        Builder $builder,
        Authenticatable|User $sender,
        Authenticatable|User $receiver
    ): Builder {
        return $builder
            ->where(function (Builder $query)  use ($receiver, $sender) {
                return $query
                    ->sendOrReceivedBy($sender)
                    ->sendOrReceivedBy($receiver);
            });
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id', 'id');
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id', 'id');
    }
}
