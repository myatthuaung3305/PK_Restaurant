<x-layouts.app title="My Profile - Pandan Kitchen">
    <section class="section">
        <h1>My Profile</h1>
        <div class="panel">
            <form method="post" action="{{ route('profile.update') }}" class="form-grid">
                @csrf
                @method('put')

                <label>Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required>

                <label>Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required>

                <button type="submit" class="btn">Update Profile</button>
            </form>
        </div>
    </section>

    <section class="section">
        <h2>Change Password</h2>
        <div class="panel">
            <form method="post" action="{{ route('profile.password.update') }}" class="form-grid">
                @csrf
                @method('put')

                <label>Current Password</label>
                <input type="password" name="current_password" required>

                <label>New Password</label>
                <input type="password" name="password" required>

                <label>Confirm New Password</label>
                <input type="password" name="password_confirmation" required>

                <button type="submit" class="btn">Update Password</button>
            </form>
        </div>
    </section>
</x-layouts.app>
