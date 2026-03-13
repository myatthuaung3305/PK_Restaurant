<x-layouts.app title="Admin - Pandan Kitchen">
    <section class="section">
        <h1>Admin</h1>

        <div class="summary-grid">
            <article class="summary-card">
                <span>Orders</span>
                <strong>{{ $summary['orders'] }}</strong>
            </article>
            <article class="summary-card">
                <span>Revenue</span>
                <strong>${{ number_format((float) $summary['revenue'], 2) }}</strong>
            </article>
            <article class="summary-card">
                <span>Active Menu Items</span>
                <strong>{{ $summary['active_menu_items'] }}</strong>
            </article>
            <article class="summary-card">
                <span>Feedback</span>
                <strong>{{ $summary['feedback'] }}</strong>
            </article>
        </div>

        <div class="admin-grid">
            <div class="panel">
                <h2>Add Item</h2>
                <form method="post" action="{{ route('admin.menu.store') }}" enctype="multipart/form-data" class="form-grid">
                    @csrf
                    <label>Item Name</label>
                    <input type="text" name="name" required>

                    <label>Category</label>
                    <input type="text" name="category" list="category-options" placeholder="Breakfast / Meals / Sides / Drinks" required>
                    <datalist id="category-options">
                        @foreach($categories as $category)
                            <option value="{{ $category }}"></option>
                        @endforeach
                    </datalist>

                    <label>Description</label>
                    <textarea name="description" rows="3"></textarea>

                    <label>Price</label>
                    <input type="number" name="price" step="0.01" min="0.01" required>

                    <label>Image File</label>
                    <input type="file" name="image_file" accept=".jpg,.jpeg,.png,.webp,.gif">

                    <button type="submit" class="btn">Add Item</button>
                </form>
            </div>

            <div class="panel">
                <h2>Feedback Report</h2>
                <form method="get" action="{{ route('admin.dashboard') }}" class="form-grid">
                    <div class="filter-grid compact">
                        <div>
                            <label>From</label>
                            <input type="date" name="from" value="{{ $from }}" required>
                        </div>
                        <div>
                            <label>To</label>
                            <input type="date" name="to" value="{{ $to }}" required>
                        </div>
                        <div class="filter-actions">
                            <button type="submit" class="btn">Generate Report</button>
                        </div>
                    </div>
                </form>

                <div class="table-wrap mt-16">
                    <table class="responsive-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Promotion</th>
                                <th>SMS</th>
                                <th>WhatsApp</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($feedbackRows as $row)
                                <tr>
                                    <td data-label="Name">{{ $row->name }}</td>
                                    <td data-label="Email">{{ $row->email }}</td>
                                    <td data-label="Phone">{{ $row->phone }}</td>
                                    <td data-label="Promotion">{{ $row->promotion }}</td>
                                    <td data-label="SMS">{{ $row->channel_sms }}</td>
                                    <td data-label="WhatsApp">{{ $row->channel_whatsapp }}</td>
                                    <td data-label="Email">{{ $row->channel_email }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="panel mt-16">
            <h2>Menu</h2>
            <div class="table-wrap">
                <table class="responsive-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($menuItems as $item)
                            <tr>
                                <td data-label="ID">{{ $item->id }}</td>
                                <td data-label="Name">{{ $item->name }}</td>
                                <td data-label="Category">{{ $item->category }}</td>
                                <td data-label="Price">${{ number_format((float) $item->price, 2) }}</td>
                                <td data-label="Status">
                                    <span class="status-badge {{ $item->is_active ? 'status-active' : 'status-cancelled' }}">
                                        {{ $item->is_active ? 'Active' : 'Hidden' }}
                                    </span>
                                </td>
                                <td data-label="Action">
                                    <form method="post" action="{{ route('admin.menu.toggle', $item) }}">
                                        @csrf
                                        <button class="btn btn-secondary" type="submit">{{ $item->is_active ? 'Hide' : 'Restore' }}</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="panel mt-16">
            <h2>Order History</h2>
            <div class="table-wrap">
                <table class="responsive-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Customer</th>
                            <th>Phone</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Update</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td data-label="ID">#{{ $order->id }}</td>
                                <td data-label="Customer">{{ $order->customer_name }}</td>
                                <td data-label="Phone">{{ $order->phone }}</td>
                                <td data-label="Total">${{ number_format((float) $order->total_amount, 2) }}</td>
                                <td data-label="Status">
                                    <span class="status-badge {{ $order->status_class }}">{{ $order->status }}</span>
                                </td>
                                <td data-label="Update">
                                    @if($order->availableNextStatuses())
                                        <form method="post" action="{{ route('admin.orders.status', $order) }}" class="inline-status-form">
                                            @csrf
                                            <select name="status" required>
                                                @foreach($order->availableNextStatuses() as $status)
                                                    <option value="{{ $status }}">{{ $status }}</option>
                                                @endforeach
                                            </select>
                                            <button class="btn btn-secondary" type="submit">Update</button>
                                        </form>
                                    @else
                                        <span class="small-muted">Done</span>
                                    @endif
                                </td>
                                <td data-label="Date">{{ $order->created_at->format('M d, Y h:i A') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</x-layouts.app>
