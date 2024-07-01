<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $product = $request->all();

        $cart = session()->get('cart', []);
        $cart[] = $product;
        session()->put('cart', $cart);

        return response()->json(['status' => 'success', 'message' => 'Producto agregado al carrito']);
    }

    public function showCart()
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }
}
