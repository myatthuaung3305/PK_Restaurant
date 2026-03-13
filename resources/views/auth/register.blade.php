<x-layouts.app title="Sign Up - Pandan Kitchen">
    <section class="auth-wrap">
        <div class="auth-card">
            <h1>Sign Up</h1>
            <form method="post" action="{{ route('register.store') }}" class="form-grid">
                @csrf
                <label>Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required>

                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required>

                <label>Password</label>
                <input type="password" name="password" required>

                <label>Confirm Password</label>
                <input type="password" name="password_confirmation" required>

                <button type="submit" class="btn">Create Account</button>
            </form>
            <p>Already have an account? <a href="{{ route('login') }}">Login</a></p>
        </div>
    </section>
</x-layouts.app>
