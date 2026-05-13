<?php

namespace App\Http\Controllers;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Gate;

use App\Models\Review;
use App\Models\Phone;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Phone $phone){
    $data = $request->validate([
        'content' =>'required|string|max:1000',
        'rating' => 'required|integer|min:1|max:5'
        ]);

        $content = $data['content'];
        $rating = $data['rating'];
        Review::create([
            'user_id' => auth()->id(),
            'phone_id' => $phone->id,
            'content' => $content,
            'rating' => $rating,
            'author' => auth()->user()->name,
            'published_at' => now()
        ]);

        return redirect()
            ->back()
            ->with('success', 'Спасибо за отзыв!')
            ->withFragment('reviews');
    }

    public function destroy(Review $review)
    {
        Gate::authorize('delete', $review);

        $review->delete();

        return back()->with('success', 'Отзыв удален')
            ->withFragment('reviews');
    }
}
