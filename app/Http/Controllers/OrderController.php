<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function confirm()
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('menu.index')->with('error', 'Please add items before confirming order.');
        }

        $total = collect($cart)->sum(fn ($item) => $item['price'] * $item['quantity']);

        return view('order.confirm', compact('cart', 'total'));
    }

    public function place(Request $request): RedirectResponse
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('menu.index')->with('error', 'Cart is empty.');
        }

        $user = $request->user();

        $data = $request->validate([
            'customer_name' => [$user ? 'nullable' : 'required', 'string', 'min:2', 'max:120'],
            'phone' => ['required', 'string', 'min:8', 'max:15'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        $total = collect($cart)->sum(fn ($item) => $item['price'] * $item['quantity']);
        $customerName = $user?->name ?? $data['customer_name'];

        $order = DB::transaction(function () use ($data, $cart, $total, $request, $customerName) {
            $order = Order::query()->create([
                'user_id' => optional($request->user())->id,
                'customer_name' => $customerName,
                'phone' => preg_replace('/[^0-9+]/', '', $data['phone']) ?? '',
                'notes' => $data['notes'] ?? '',
                'total_amount' => $total,
                'order_type' => 'Take Out',
                'status' => Order::STATUSES[0],
            ]);

            foreach ($cart as $line) {
                OrderItem::query()->create([
                    'order_id' => $order->id,
                    'menu_item_id' => $line['menu_item_id'],
                    'item_name' => $line['name'],
                    'quantity' => (int) $line['quantity'],
                    'unit_price' => (float) $line['price'],
                    'line_total' => (float) $line['price'] * (int) $line['quantity'],
                ]);
            }

            return $order;
        });

        session()->forget('cart');
        session(['last_order_id' => $order->id]);

        return redirect()->route('order.receipt', $order)->with('success', 'Order placed successfully.');
    }

    public function receipt(Order $order)
    {
        $user = auth()->user();
        $canView = (bool) (
            ($user && ($user->is_admin || $order->user_id === $user->id))
            || (session('last_order_id') === $order->id)
        );
        abort_unless($canView, 403);

        $order->load('items');

        return view('order.receipt', compact('order'));
    }

    public function history(Request $request)
    {
        $orders = Order::query()
            ->where('user_id', $request->user()->id)
            ->withCount('items')
            ->orderByDesc('id')
            ->get();

        return view('order.history', compact('orders'));
    }
}
