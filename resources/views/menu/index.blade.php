<x-layouts.app title="Take Order - Pandan Kitchen">
    <section class="section">
        <div class="section-heading">
            <div>
                <h1>Take Order</h1>
                <p>Search the menu and filter by category.</p>
            </div>
            <div class="row-inline">
                <a class="btn" href="{{ route('cart.index') }}">View Cart</a>
                <a class="btn btn-secondary" href="{{ route('order.confirm') }}">Confirm Order</a>
            </div>
        </div>

        <form method="get" action="{{ route('menu.index') }}" class="panel filter-form">
            <div class="filter-grid">
                <div>
                    <label for="q">Search</label>
                    <input id="q" type="search" name="q" value="{{ $searchQuery }}" placeholder="Search meals, drinks, breakfast...">
                </div>
                <div>
                    <label for="category">Category</label>
                    <select id="category" name="category">
                        <option value="">All categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}" @selected($selectedCategory === $category)>{{ $category }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-actions">
                    <button type="submit" class="btn">Apply</button>
                    <a class="btn btn-secondary" href="{{ route('menu.index') }}">Reset</a>
                </div>
            </div>
        </form>

        @if($items->isEmpty())
            <div class="panel empty-state">
                <p>No items matched your search.</p>
            </div>
        @else
            <div class="results-row">
                <p>{{ $items->count() }} items found</p>
            </div>

            <div class="card-grid">
                @foreach($items as $item)
                    <article class="card menu-card">
                        @if($item->image_path !== '')
                            <img src="{{ asset($item->image_path) }}" alt="{{ $item->name }}">
                        @endif
                        <span class="card-category">{{ $item->category }}</span>
                        <h3>{{ $item->name }}</h3>
                        <p>{{ $item->description }}</p>
                        <div class="price">${{ number_format((float)$item->price, 2) }}</div>
                        <form method="post" action="{{ route('cart.add', $item->id) }}" class="card-form">
                            @csrf
                            <input type="hidden" name="next" value="{{ request()->getRequestUri() }}">
                            <input type="number" name="quantity" value="1" min="1" max="20">
                            <button type="submit" class="btn">Add to Cart</button>
                        </form>
                    </article>
                @endforeach
            </div>
        @endif
    </section>
</x-layouts.app>
