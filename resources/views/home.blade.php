<x-layouts.app title="Pandan Kitchen">
    <section class="hero">
        <div class="hero-copy">
            <span class="eyebrow">Pandan Kitchen</span>
            <h1>Pandan Kitchen</h1>
            <p>Order Burmese breakfast, meals, sides, and drinks for take out.</p>
            <div class="hero-actions">
                <a class="btn" href="{{ route('menu.index') }}">Start Order</a>
                <a class="btn btn-secondary" href="#feedback">Send Feedback</a>
            </div>
            <div class="hero-stats">
                <article>
                    <strong>{{ $featuredItems->count() }}</strong>
                    <span>Home items</span>
                </article>
                <article>
                    <strong>4</strong>
                    <span>Categories</span>
                </article>
                <article>
                    <strong>Take Out</strong>
                    <span>Order type</span>
                </article>
            </div>
        </div>
        <div class="hero-visual">
            <img src="{{ asset('assets/images/intro_image.jpg') }}" alt="Pandan Kitchen">
            <div class="hero-note">
                <span>Menu</span>
                <strong>Breakfast, meals, sides, and drinks</strong>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="section-heading">
            <div>
                <span class="eyebrow">Popular Dishes</span>
                <h2>Menu Picks</h2>
            </div>
            <a class="btn btn-secondary" href="{{ route('menu.index') }}">View Menu</a>
        </div>
        <div class="card-grid">
            @foreach($featuredItems as $item)
                <article class="card">
                    @if($item->image_path !== '')
                        <img src="{{ asset($item->image_path) }}" alt="{{ $item->name }}">
                    @endif
                    <span class="card-category">{{ $item->category }}</span>
                    <h3>{{ $item->name }}</h3>
                    <p>{{ $item->description }}</p>
                    <div class="price">${{ number_format((float)$item->price, 2) }}</div>
                    <form method="post" action="{{ route('cart.add', $item->id) }}">
                        @csrf
                        <input type="hidden" name="next" value="{{ request()->getRequestUri() }}">
                        <input type="number" name="quantity" value="1" min="1" max="20">
                        <button type="submit" class="btn">Add to Cart</button>
                    </form>
                </article>
            @endforeach
        </div>
    </section>

    <section class="section" id="feedback">
        <div class="section-heading">
            <div>
                <span class="eyebrow">Contact</span>
                <h2>Contact & Feedback</h2>
            </div>
        </div>
        <form method="post" action="{{ route('feedback.store') }}" class="panel form-grid">
            @csrf
            <label>Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required>

            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required>

            <label>Phone</label>
            <input type="text" name="phone" value="{{ old('phone') }}" required>

            <label>Feedback</label>
            <textarea name="message" rows="4" required>{{ old('message') }}</textarea>

            <label>Do you want promotion?</label>
            <div class="row-inline">
                <label><input type="radio" name="promotion" value="Y" {{ old('promotion') === 'Y' ? 'checked' : '' }} required> Yes</label>
                <label><input type="radio" name="promotion" value="N" {{ old('promotion') === 'N' ? 'checked' : '' }}> No</label>
            </div>

            <div id="channelBox" class="row-inline">
                <label><input type="checkbox" name="sms" value="Y"> SMS</label>
                <label><input type="checkbox" name="whatsapp" value="Y"> WhatsApp</label>
                <label><input type="checkbox" name="emailch" value="Y"> Email</label>
            </div>

            <button type="submit" class="btn">Send Feedback</button>
        </form>
    </section>

    @push('scripts')
    <script>
        const promotionInputs = document.querySelectorAll('input[name="promotion"]');
        const channelBox = document.getElementById('channelBox');

        function toggleChannels() {
            const selected = document.querySelector('input[name="promotion"]:checked');
            channelBox.style.display = selected && selected.value === 'Y' ? 'flex' : 'none';
        }

        promotionInputs.forEach((input) => input.addEventListener('change', toggleChannels));
        toggleChannels();
    </script>
    @endpush
</x-layouts.app>
