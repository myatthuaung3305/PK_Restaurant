<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('q', ''));
        $category = trim((string) $request->query('category', ''));

        $categories = MenuItem::query()
            ->active()
            ->select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        $query = MenuItem::query()
            ->active()
            ->when($search !== '', function ($builder) use ($search) {
                $builder->where(function ($nested) use ($search) {
                    $nested
                        ->where('name', 'like', '%' . $search . '%')
                        ->orWhere('description', 'like', '%' . $search . '%')
                        ->orWhere('category', 'like', '%' . $search . '%');
                });
            })
            ->when($category !== '', fn ($builder) => $builder->where('category', $category))
            ->orderBy('category')
            ->orderBy('name');

        $items = $query->get();

        return view('menu.index', [
            'items' => $items,
            'categories' => $categories,
            'selectedCategory' => $category,
            'searchQuery' => $search,
        ]);
    }
}
