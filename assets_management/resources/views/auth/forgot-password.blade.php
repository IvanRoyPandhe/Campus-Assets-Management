<x-guest-layout>
    <div class="auth-header">
        <div class="logo">
            <i class="bi bi-key"></i>
        </div>
        <h1>Reset Password</h1>
        <p>Enter your email to receive a reset link</p>
    </div>
    
    <div class="auth-body">
        <!-- Session Status -->
        @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="bi bi-check-circle me-2"></i> {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div class="form-floating mb-4">
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="name@example.com" value="{{ old('email') }}" required autofocus>
                <label for="email">Email Address</label>
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary btn-auth">
                <i class="bi bi-envelope me-2"></i> Email Password Reset Link
            </button>
        </form>
    </div>
    
    <div class="auth-footer">
        <div class="auth-divider">
            <span>Remember your password?</span>
        </div>
        <a href="{{ route('login') }}" class="btn btn-outline-primary">
            <i class="bi bi-box-arrow-in-right me-2"></i> Back to Login
        </a>
    </div>
</x-guest-layout>