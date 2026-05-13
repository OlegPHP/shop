<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

class CheckoutController extends Controller
{
    public function index()
    {
        $items = CartItem::with('phone')
            ->where('user_id', auth()->id())->get();

        if($items->isEmpty()){
            return redirect()->route('cart.index');
        }

        $total = $items->sum(fn($i) => $i->price * $i->quantity);
        return view('checkout.index', compact('items', 'total'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
        ]);

        CartItem::where('user_id', auth()->id())->delete();

        return redirect()->route('checkout.success')->with('name', $data['name']);
    }

    public function success()
    {
        $name = session('name');
        return view('checkout.success', compact('name'));
    }


}
