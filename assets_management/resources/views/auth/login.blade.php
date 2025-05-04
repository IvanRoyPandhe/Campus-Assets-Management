<x-guest-layout>
    <div class="auth-header">
        <div class="logo">
            <i class="bi bi-boxes"></i>
        </div>
        <h1>Welcome Back</h1>
        <p>Sign in to continue to Asset Management</p>
    </div>
    
    <div class="auth-body">
        <!-- Session Status -->
        @if (session('status'))
            <div class="alert alert-info alert-dismissible fade show mb-4" role="alert">
                <i class="bi bi-info-circle me-2"></i> {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="form-floating mb-4">
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="name@example.com" value="{{ old('email') }}" required autofocus autocomplete="username">
                <label for="email">Email Address</label>
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Password -->
            <div class="form-floating mb-4">
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password" required autocomplete="current-password">
                <label for="password">Password</label>
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
                <label class="form-check-label" for="remember_me">
                    Remember me
                </label>
            </div>

            <button type="submit" class="btn btn-primary btn-auth">
                <i class="bi bi-box-arrow-in-right me-2"></i> Sign In
            </button>
            
            @if (Route::has('password.request'))
                <div class="text-center mt-4">
                    <a href="{{ route('password.request') }}" class="text-decoration-none">
                        Forgot your password?
                    </a>
                </div>
            @endif
        </form>
    </div>
    
    <div class="auth-footer">
        <div class="auth-divider">
            <span>Don't have an account?</span>
        </div>
        <a href="{{ route('register') }}" class="btn btn-outline-primary">
            <i class="bi bi-person-plus me-2"></i> Create Account
        </a>
    </div>
</x-guest-layout>