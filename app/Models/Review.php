<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Phone;

class Review extends Model
{

    protected $fillable = [
        'phone_id',
        'user_id',
        'rating',
        'author',
        'content',
        'published_at',
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function phone(): BelongsTo
    {
        return $this->belongsTo(Phone::class);
    }
}
