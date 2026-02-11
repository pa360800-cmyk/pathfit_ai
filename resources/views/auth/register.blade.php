<x-login-layout>
    <div class="form-header">
        <h2>Sign up</h2>
        <p>Already have an account? <a href="{{ route('login') }}">Sign in</a></p>
    </div>

    @if(session('success'))
        <div class="mt-4 text-sm text-green-600 bg-green-100 p-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if(session('failed'))
        <div class="mt-4 text-sm text-red-600 bg-red-100 p-3 rounded">
            {{ session('failed') }}
        </div>
    @endif

    <form method="POST" action="{{ route('register.post') }}">
        @csrf

        <!-- First Name -->
        <div class="form-group">
            <label for="fname">First name</label>
            <div class="input-wrapper">
                <svg class="input-icon icon-mail" viewBox="0 0 24 24">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                    <circle cx="12" cy="7" r="4"/>
                </svg>
                <input type="text" id="fname" name="fname" placeholder="John" value="{{ old('fname') }}" required autofocus autocomplete="given-name">
            </div>
            @error('fname')
                <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
            @enderror
        </div>

        <!-- Middle Name -->
        <div class="form-group">
            <label for="mname">Middle name (optional)</label>
            <div class="input-wrapper">
                <svg class="input-icon icon-mail" viewBox="0 0 24 24">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                    <circle cx="12" cy="7" r="4"/>
                </svg>
                <input type="text" id="mname" name="mname" placeholder="Middle" value="{{ old('mname') }}" autocomplete="additional-name">
            </div>
            @error('mname')
                <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
            @enderror
        </div>

        <!-- Last Name -->
        <div class="form-group">
            <label for="lname">Last name</label>
            <div class="input-wrapper">
                <svg class="input-icon icon-mail" viewBox="0 0 24 24">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                    <circle cx="12" cy="7" r="4"/>
                </svg>
                <input type="text" id="lname" name="lname" placeholder="Doe" value="{{ old('lname') }}" required autocomplete="family-name">
            </div>
            @error('lname')
                <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
            @enderror
        </div>

        <!-- Course -->
        <div class="form-group">
            <label for="course">Course</label>
            <div class="input-wrapper">
                <svg class="input-icon icon-mail" viewBox="0 0 24 24">
                    <rect x="3" y="5" width="18" height="14" rx="2"/>
                    <path d="M3 7l9 6 9-6"/>
                </svg>
                <input type="text" id="course" name="course" placeholder="e.g. Computer Science" value="{{ old('course') }}" required>
            </div>
            @error('course')
                <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
            @enderror
        </div>

        <!-- Gender -->
        <div class="form-group">
            <label for="gender">Gender</label>
            <div class="input-wrapper">
                <select id="gender" name="gender" required>
                    <option value="">Select Gender</option>
                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                </select>
            </div>
            @error('gender')
                <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
            @enderror
        </div>

        <!-- Email Address -->
        <div class="form-group">
            <label for="email">Email address</label>
            <div class="input-wrapper">
                <svg class="input-icon icon-mail" viewBox="0 0 24 24">
                    <rect x="3" y="5" width="18" height="14" rx="2"/>
                    <path d="M3 7l9 6 9-6"/>
                </svg>
                <input type="email" id="email" name="email" placeholder="you@example.com" value="{{ old('email') }}" required autocomplete="username">
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
                <input type="password" id="password" name="password" placeholder="••••••••" required autocomplete="new-password">
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

        <!-- Confirm Password -->
        <div class="form-group">
            <label for="password_confirmation">Confirm password</label>
            <div class="input-wrapper">
                <svg class="input-icon icon-lock" viewBox="0 0 24 24">
                    <rect x="5" y="11" width="14" height="10" rx="2"/>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                </svg>
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="••••••••" required autocomplete="new-password">
                <button type="button" class="toggle-password" onclick="togglePasswordConfirmation()">
                    <svg class="icon-eye" width="20" height="20" viewBox="0 0 24 24">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                </button>
            </div>
            @error('password_confirmation')
                <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
            @enderror
        </div>

        <!-- Submit Button -->
        <button type="submit" class="submit-btn">Sign up</button>


    </form>
</x-login-layout>
