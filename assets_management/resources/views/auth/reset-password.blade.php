<x-guest-layout>
    <div class="auth-header">
        <div class="logo">
            <i class="bi bi-shield-lock"></i>
        </div>
        <h1>New Password</h1>
        <p>Create a new secure password</p>
    </div>
    
    <div class="auth-body">
        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <div class="form-floating mb-4">
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="name@example.com" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username">
                <label for="email">Email Address</label>
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Password -->
            <div class="form-floating mb-4">
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password" required autocomplete="new-password">
                <label for="password">New Password</label>
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="form-floating mb-4">
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" required autocomplete="new-password">
                <label for="password_confirmation">Confirm Password</label>
            </div>

            <button type="submit" class="btn btn-primary btn-auth">
                <i class="bi bi-check-circle me-2"></i> Reset Password
            </button>
        </form>
    </div>
</x-guest-layout>