<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Phone;

class PhoneSpec extends Model
{
    public function phone(): BelongsTo
    {
        return $this->belongsTo(Phone::class);
    }
}
