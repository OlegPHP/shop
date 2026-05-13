<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Phone;

class Brand extends Model
{
    public function phones(): HasMany
    {
        return $this->hasMany(Phone::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
