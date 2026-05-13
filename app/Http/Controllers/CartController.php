<?php

namespace App\Http\Controllers;
use App\Models\Phone;
use App\Models\CartItem;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Phone $phone){

        $user = auth()->user();
        if(!$user){
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $item = CartItem::where('user_id', $user->id)
            ->where('phone_id', $phone->id)->first();

        if($item){
            $item->increment('quantity');
        } else {
            $item = CartItem::create([
                'user_id' => $user->id,
                'phone_id' => $phone->id,
                'quantity' => 1,
                'price' => $phone->price
            ]);
        }
        return response()->json([
            'success' => true,
            'quantity' => $item->quantity
        ]);

    }

    public function index(){
        $user = auth()->user();
        $items = CartItem::with('phone')
            ->where('user_id', $user->id)->get();

        return view('cart.index', compact('items'));
    }

    public function remove(CartItem $item){
        abort_if($item->user_id !== auth()->id(), 403);

        $item->delete();

        $total = CartItem::where('user_id', auth()->id())
            ->sum(\DB::raw('price * quantity'));

        return response()->json([
            'cart_total' => $total
        ]);
    }

    public function increase(CartItem $item){
        abort_if($item->user_id !== auth()->id(), 403);
        $item->increment('quantity');
        $total = CartItem::where('user_id', auth()->id())
            ->sum(\DB::raw('price * quantity'));

        return response()->json([
            'quantity' => $item->quantity,
            'item_total' => $item->price * $item->quantity,
            'cart_total' => $total,
        ]);
    }

    public function decrease(CartItem $item){
        abort_if($item->user_id !== auth()->id(), 403);

        if ($item->quantity > 1) {
            $item->decrement('quantity');

            $deleted = false;
        } else {
            $item->delete();
            $deleted = true;
        }

        $total = CartItem::where('user_id', auth()->id())
            ->sum(\DB::raw('price * quantity'));

        return response()->json([
            'quantity' => $deleted ? 0 : $item->quantity,
            'item_total' => $deleted ? 0 : $item->price * $item->quantity,
            'cart_total' => $total,
            'deleted' => $deleted
        ]);


    }
}
