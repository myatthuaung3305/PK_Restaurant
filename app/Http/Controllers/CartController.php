<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        $total = collect($cart)->sum(fn ($item) => $item['price'] * $item['quantity']);

        return view('cart.index', compact('cart', 'total'));
    }

    public function add(Request $request, int $menuItemId): RedirectResponse
    {
        $quantity = max(1, (int) $request->input('quantity', 1));
        $item = MenuItem::query()->active()->findOrFail($menuItemId);
        $next = (string) $request->input('next', route('menu.index'));

        $cart = session('cart', []);
        $key = (string) $item->id;

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] += $quantity;
        } else {
            $cart[$key] = [
                'menu_item_id' => $item->id,
                'name' => $item->name,
                'price' => (float) $item->price,
                'quantity' => $quantity,
            ];
        }

        session(['cart' => $cart]);

        if (!str_starts_with($next, '/')) {
            $next = route('menu.index');
        }

        return redirect($next)->with('success', 'Item added to cart.');
    }

    public function update(Request $request): RedirectResponse
    {
        $quantities = $request->input('quantities', []);
        $cart = session('cart', []);

        foreach ($quantities as $id => $qty) {
            $id = (string) $id;
            if (!isset($cart[$id])) {
                continue;
            }

            $quantity = max(0, (int) $qty);
            if ($quantity === 0) {
                unset($cart[$id]);
            } else {
                $cart[$id]['quantity'] = $quantity;
            }
        }

        session(['cart' => $cart]);

        return redirect()->route('cart.index')->with('success', 'Cart updated.');
    }

    public function remove(int $menuItemId): RedirectResponse
    {
        $cart = session('cart', []);
        unset($cart[(string) $menuItemId]);
        session(['cart' => $cart]);

        return redirect()->route('cart.index')->with('success', 'Item removed from cart.');
    }

    public function clear(): RedirectResponse
    {
        session()->forget('cart');

        return redirect()->route('cart.index')->with('success', 'Cart cleared.');
    }
}
