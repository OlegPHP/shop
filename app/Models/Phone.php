<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PhoneSpec;
use App\Models\PhoneImage;
use App\Models\Review;
use App\Models\CartItem;
use App\Models\Brand;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Phone extends Model
{
    public function phoneSpec(): HasOne
    {
        return $this->hasOne(PhoneSpec::class);
    }

    public function phoneImages(): HasMany
    {
        return $this->hasMany(PhoneImage::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }
    public function getRouteKeyName()
    {
        return 'slug';
    }

}
