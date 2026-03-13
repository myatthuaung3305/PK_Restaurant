<x-layouts.app title="Cart - Pandan Kitchen">
    <section class="section">
        <h1>Your Cart</h1>

        @if(empty($cart))
            <div class="panel">
                <p>Cart is empty. <a href="{{ route('menu.index') }}">Start your order</a>.</p>
            </div>
        @else
            <form method="post" action="{{ route('cart.update') }}" class="panel">
                @csrf
                <div class="table-wrap">
                    <table>
                        <tr>
                            <th>Item</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Subtotal</th>
                            <th>Remove</th>
                        </tr>
                        @foreach($cart as $item)
                            <tr>
                                <td>{{ $item['name'] }}</td>
                                <td>${{ number_format((float)$item['price'], 2) }}</td>
                                <td><input type="number" name="quantities[{{ $item['menu_item_id'] }}]" value="{{ $item['quantity'] }}" min="0" max="50"></td>
                                <td>${{ number_format((float)$item['price'] * (int)$item['quantity'], 2) }}</td>
                                <td>
                                    <button class="btn btn-danger" type="submit" formaction="{{ route('cart.remove', $item['menu_item_id']) }}">X</button>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <p class="total">Total: ${{ number_format((float)$total, 2) }}</p>
                <div class="row-inline">
                    <button type="submit" class="btn">Update Cart</button>
                    <button type="submit" class="btn btn-danger" formaction="{{ route('cart.clear') }}">Clear Cart</button>
                    <a class="btn" href="{{ route('order.confirm') }}">Confirm Order</a>
                </div>
            </form>
        @endif
    </section>
</x-layouts.app>