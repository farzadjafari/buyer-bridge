<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['title', 'body', 'scheduled_opening_time'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function canBeOpened(): bool
    {
        return Carbon::parse($this->scheduled_opening_time)->isPast();
    }
}
