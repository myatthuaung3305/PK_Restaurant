<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Pandan Kitchen' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/theme.css') }}">
</head>
<body>
    <div class="page-glow page-glow-left"></div>
    <div class="page-glow page-glow-right"></div>
    <header class="site-header">
        <nav class="site-nav container">
            <a class="brand" href="{{ route('home') }}">
                <span class="brand-mark">PK</span>
                <span class="brand-text">
                    <small>Burmese Kitchen</small>
                    <strong>Pandan Kitchen</strong>
                </span>
            </a>
            <div class="nav-links">
                <a href="{{ route('home') }}">Home</a>
                <a href="{{ route('menu.index') }}">Take Order</a>
                <a href="{{ route('cart.index') }}">Cart</a>
                @auth
                    @if(auth()->user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}">Admin</a>
                    @else
                        <a href="{{ route('order.history') }}">My Orders</a>
                    @endif
                    <a href="{{ route('profile.edit') }}">Profile</a>
                    <form method="post" action="{{ route('logout') }}" class="inline-form">
                        @csrf
                        <button type="submit" class="link-btn">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}">Login</a>
                    <a href="{{ route('register') }}">Sign Up</a>
                @endauth
            </div>
        </nav>
    </header>

    <main class="container main-wrap">
        @if(session('success'))
            <div class="flash flash-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="flash flash-error">{{ session('error') }}</div>
        @endif
        @if($errors->any())
            <div class="flash flash-error">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{ $slot }}
    </main>

    <footer class="site-footer">
        <p>&copy; {{ now()->year }} Pandan Kitchen</p>
    </footer>

    @stack('scripts')
</body>
</html>
