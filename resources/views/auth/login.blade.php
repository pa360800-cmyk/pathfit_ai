<x-login-layout>
    <!-- Session Status -->
    @if (session('status'))
        <div class="mb-4 text-sm text-green-600 bg-green-50 border border-green-200 rounded-md p-3">
            {{ session('status') }}
        </div>
    @endif

    <div class="form-header">
        <h2>Sign in</h2>
        <p>Don't have an account? <a href="{{ route('register') }}">Sign up</a></p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="form-group">
            <label for="email">Email address</label>
            <div class="input-wrapper">
                <svg class="input-icon icon-mail" viewBox="0 0 24 24">
                    <rect x="3" y="5" width="18" height="14" rx="2"/>
                    <path d="M3 7l9 6 9-6"/>
                </svg>
                <input type="email" id="email" name="email" placeholder="you@example.com" value="{{ old('email') }}" required autofocus autocomplete="username">
            </div>
            @error('email')
                <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password">Password</label>
            <div class="input-wrapper">
                <svg class="input-icon icon-lock" viewBox="0 0 24 24">
                    <rect x="5" y="11" width="14" height="10" rx="2"/>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                </svg>
                <input type="password" id="password" name="password" placeholder="••••••••" required autocomplete="current-password">
                <button type="button" class="toggle-password" onclick="togglePassword()">
                    <svg class="icon-eye" width="20" height="20" viewBox="0 0 24 24">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                </button>
            </div>
            @error('password')
                <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
            @enderror
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="form-options">
            <div class="remember-me">
                <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                <label for="remember">Remember me</label>
            </div>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="forgot-password">Forgot password?</a>
            @endif
        </div>

        <!-- Submit Button -->
        <button type="submit" class="submit-btn">Sign in</button>


    </form>
</x-login-layout>
