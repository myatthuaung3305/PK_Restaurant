<x-layouts.app title="Receipt - Pandan Kitchen">
    <section class="section">
        <div class="section-heading">
            <div>
                <h1>Take Out Receipt</h1>
                <p>Order #{{ $order->id }}</p>
            </div>
            <span class="status-badge {{ $order->status_class }}">{{ $order->status }}</span>
        </div>

        <div class="panel">
            <div class="receipt-meta">
                <p><strong>Date:</strong> {{ $order->created_at->format('M d, Y h:i A') }}</p>
                <p><strong>Customer:</strong> {{ $order->customer_name }}</p>
                <p><strong>Phone:</strong> {{ $order->phone }}</p>
                <p><strong>Order Type:</strong> {{ $order->order_type }}</p>
            </div>

            @if($order->notes !== '')
                <p><strong>Notes:</strong> {{ $order->notes }}</p>
            @endif

            <div class="table-wrap">
                <table class="responsive-table">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td data-label="Item">{{ $item->item_name }}</td>
                                <td data-label="Qty">{{ (int) $item->quantity }}</td>
                                <td data-label="Price">${{ number_format((float) $item->unit_price, 2) }}</td>
                                <td data-label="Subtotal">${{ number_format((float) $item->line_total, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <p class="total">Total: ${{ number_format((float) $order->total_amount, 2) }}</p>
            <div class="row-inline">
                @auth
                    <a href="{{ route('order.history') }}" class="btn btn-secondary">My Orders</a>
                @endauth
                <a href="{{ route('menu.index') }}" class="btn">Take New Order</a>
                <a href="{{ route('home') }}" class="btn btn-secondary">Back Home</a>
            </div>
        </div>
    </section>
</x-layouts.app>
