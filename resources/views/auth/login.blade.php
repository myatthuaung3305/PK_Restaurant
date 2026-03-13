<x-layouts.app title="Login - Pandan Kitchen">
    <section class="auth-wrap">
        <div class="auth-card">
            <h1>Login</h1>
            <form method="post" action="{{ route('login.attempt') }}" class="form-grid">
                @csrf
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required>

                <label>Password</label>
                <input type="password" name="password" required>

                <label class="row-inline"><input type="checkbox" name="remember" value="1"> Remember me</label>

                <button type="submit" class="btn">Login</button>
            </form>
            <p>Need an account? <a href="{{ route('register') }}">Sign up</a></p>
        </div>
    </section>
</x-layouts.app>
