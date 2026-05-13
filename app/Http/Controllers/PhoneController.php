<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Phone;

class PhoneController extends Controller
{
    public function show(Phone $phone)
    {
        $similarPhones = Phone::where('id', '!=', $phone->id)
            ->where('brand_id', $phone->brand_id)
            ->take(5)
            ->get();

        return view('phone.show', compact('phone', 'similarPhones'));
    }
}
