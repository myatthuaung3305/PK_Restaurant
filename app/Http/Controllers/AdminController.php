<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\MenuItem;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        $from = $request->query('from', now()->startOfMonth()->toDateString());
        $to = $request->query('to', now()->toDateString());

        $menuItems = MenuItem::query()->orderByDesc('id')->get();
        $orders = Order::query()
            ->with('items')
            ->whereBetween('created_at', [$from . ' 00:00:00', $to . ' 23:59:59'])
            ->orderByDesc('id')
            ->limit(200)
            ->get();

        $feedbackRows = Feedback::query()
            ->whereBetween('feedback_date', [$from, $to])
            ->orderByDesc('feedback_date')
            ->get();

        $summary = [
            'active_menu_items' => $menuItems->where('is_active', true)->count(),
            'orders' => $orders->count(),
            'revenue' => $orders->sum('total_amount'),
            'feedback' => $feedbackRows->count(),
        ];

        $categories = $menuItems
            ->pluck('category')
            ->filter()
            ->unique()
            ->sort()
            ->values();

        return view('admin.dashboard', compact('menuItems', 'orders', 'feedbackRows', 'from', 'to', 'summary', 'categories'));
    }

    public function storeMenuItem(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'category' => ['required', 'string', 'max:60'],
            'description' => ['nullable', 'string', 'max:500'],
            'price' => ['required', 'numeric', 'min:0.01'],
            'image_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:4096'],
        ]);

        $imagePath = '';
        if ($request->hasFile('image_file')) {
            $imagePath = $request->file('image_file')->store('uploads/menu', 'public');
            $imagePath = 'storage/' . $imagePath;
        }

        MenuItem::query()->create([
            'name' => $data['name'],
            'category' => $data['category'],
            'description' => $data['description'] ?? '',
            'price' => $data['price'],
            'image_path' => $imagePath,
            'is_active' => true,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'New menu item added successfully.');
    }

    public function toggleMenuItem(MenuItem $menuItem): RedirectResponse
    {
        $menuItem->update([
            'is_active' => !$menuItem->is_active,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Menu item status updated.');
    }

    public function updateOrderStatus(Request $request, Order $order): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'string', 'in:' . implode(',', Order::STATUSES)],
        ]);

        if (!in_array($data['status'], $order->availableNextStatuses(), true)) {
            return redirect()->route('admin.dashboard')->with('error', 'Invalid status transition.');
        }

        $order->update([
            'status' => $data['status'],
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Order status updated.');
    }
}
