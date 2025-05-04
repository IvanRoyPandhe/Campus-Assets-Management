<x-guest-layout>
    <div class="auth-header">
        <div class="logo">
            <i class="bi bi-person-plus"></i>
        </div>
        <h1>Create Account</h1>
        <p>Join the Asset Management System</p>
    </div>
    
    <div class="auth-body">
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="form-floating mb-4">
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Full Name" value="{{ old('name') }}" required autofocus autocomplete="name">
                <label for="name">Full Name</label>
                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Email Address -->
            <div class="form-floating mb-4">
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="name@example.com" value="{{ old('email') }}" required autocomplete="username">
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
                <label for="password">Password</label>
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
                <i class="bi bi-person-plus me-2"></i> Register
            </button>
        </form>
    </div>
    
    <div class="auth-footer">
        <div class="auth-divider">
            <span>Already have an account?</span>
        </div>
        <a href="{{ route('login') }}" class="btn btn-outline-primary">
            <i class="bi bi-box-arrow-in-right me-2"></i> Sign In
        </a>
    </div>
</x-guest-layout>