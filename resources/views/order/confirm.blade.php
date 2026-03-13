<x-layouts.app title="Confirm Order - Pandan Kitchen">
    <section class="section">
        <h1>Confirm Order</h1>

        <div class="panel">
            <div class="table-wrap">
                <table>
                    <tr>
                        <th>Item</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                    </tr>
                    @foreach($cart as $item)
                        <tr>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ (int)$item['quantity'] }}</td>
                            <td>${{ number_format((float)$item['price'] * (int)$item['quantity'], 2) }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <th colspan="2">Total</th>
                        <th>${{ number_format((float)$total, 2) }}</th>
                    </tr>
                </table>
            </div>

            <form method="post" action="{{ route('order.place') }}" class="form-grid mt-16">
                @csrf
                @auth
                    <label>Customer Name</label>
                    <input type="text" value="{{ auth()->user()->name }}" readonly>
                @else
                    <label>Customer Name</label>
                    <input type="text" name="customer_name" value="{{ old('customer_name') }}" required>
                @endauth

                <label>Phone</label>
                <input type="text" name="phone" value="{{ old('phone') }}" required>

                <label>Notes</label>
                <textarea name="notes" rows="3">{{ old('notes') }}</textarea>

                <button type="submit" class="btn">Place Take Out Order</button>
            </form>
        </div>
    </section>
</x-layouts.app>
