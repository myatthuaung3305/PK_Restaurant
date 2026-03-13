<x-layouts.app title="My Orders - Pandan Kitchen">
    <section class="section">
        <div class="section-heading">
            <div>
                <h1>My Orders</h1>
                <p>Your recent orders.</p>
            </div>
            <a class="btn" href="{{ route('menu.index') }}">Start New Order</a>
        </div>

        @if($orders->isEmpty())
            <div class="panel empty-state">
                <p>No orders yet.</p>
            </div>
        @else
            <div class="panel">
                <div class="table-wrap">
                    <table class="responsive-table">
                        <thead>
                            <tr>
                                <th>Order</th>
                                <th>Date</th>
                                <th>Items</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Receipt</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td data-label="Order">#{{ $order->id }}</td>
                                    <td data-label="Date">{{ $order->created_at->format('M d, Y h:i A') }}</td>
                                    <td data-label="Items">{{ $order->items_count }}</td>
                                    <td data-label="Total">${{ number_format((float) $order->total_amount, 2) }}</td>
                                    <td data-label="Status">
                                        <span class="status-badge {{ $order->status_class }}">{{ $order->status }}</span>
                                    </td>
                                    <td data-label="Receipt">
                                        <a class="btn btn-secondary" href="{{ route('order.receipt', $order) }}">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </section>
</x-layouts.app>
