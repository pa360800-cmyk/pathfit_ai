<x-guest-layout>
    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --mint-primary: #00D9A3;
            --mint-secondary: #00B88D;
            --mint-light: #5FFFD4;
            --mint-dark: #008B6E;
            --accent-coral: #FF6B6B;
            --accent-yellow: #FFE66D;
            --bg-dark: #0A0E27;
            --bg-darker: #050816;
            --text-light: rgb(30, 243, 225);
            --text-muted: rgb(0, 0, 0);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg-darker);
            color: var(--text-light);
            overflow: hidden;
            height: 100vh;
        }

        .login-wrapper {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        /* Animated Background */
        .bg-animation {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
        }

        .gradient-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.4;
            animation: float 20s infinite ease-in-out;
        }

        .orb-1 {
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, var(--mint-primary), transparent);
            top: -10%;
            left: -10%;
            animation-delay: 0s;
        }

        .orb-2 {
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, var(--accent-coral), transparent);
            bottom: -5%;
            right: -5%;
            animation-delay: 3s;
        }

        .orb-3 {
            width: 350px;
            height: 350px;
            background: radial-gradient(circle, var(--accent-yellow), transparent);
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            animation-delay: 6s;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -30px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
        }

        .noise-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0.03;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 400 400' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' /%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)' /%3E%3C/svg%3E");
        }

        /* Main Container */
        .login-container {
            position: relative;
            z-index: 1;
            display: grid;
            grid-template-columns: 1fr 1fr;
            width: 90%;
            max-width: 1400px;
            height: 85vh;
            max-height: 900px;
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            border-radius: 32px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
        }

        /* Left Side - Brand */
        .brand-side {
            position: relative;
            padding: 80px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background: linear-gradient(135deg, rgba(0, 217, 163, 0.1) 0%, rgba(0, 139, 110, 0.05) 100%);
            border-right: 1px solid rgba(255, 255, 255, 0.08);
            overflow: hidden;
        }

        .brand-side::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle at center, rgba(0, 217, 163, 0.1) 0%, transparent 50%);
            animation: rotate 30s linear infinite;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .logo-section {
            position: relative;
            z-index: 1;
        }

        .logo {
            display: inline-flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 60px;
            animation: slideDown 0.8s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logo-icon {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, var(--mint-primary), var(--mint-light));
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            box-shadow: 0 8px 24px rgba(0, 217, 163, 0.3);
            animation: pulse 3s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { box-shadow: 0 8px 24px rgba(0, 217, 163, 0.3); }
            50% { box-shadow: 0 12px 32px rgba(0, 217, 163, 0.5); }
        }

        .logo-text {
            font-family: 'Syne', sans-serif;
            font-size: 28px;
            font-weight: 800;
            background: linear-gradient(135deg, var(--mint-light), var(--mint-primary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .brand-content h1 {
            font-family: 'Syne', sans-serif;
            font-size: 56px;
            font-weight: 800;
            line-height: 1.1;
            text-shadow: 0px 0px 0px rgb(17, 134, 115);
            margin-bottom: 24px;
            background: linear-gradient(135deg, var(--text-light), var(--mint-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: slideUp 1s ease-out 0.2s both;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .brand-content p {
            font-size: 18px;
            line-height: 1.7;
            color: var(--text-light);
            max-width: 460px;
            animation: slideUp 1s ease-out 0.4s both;
        }

        .stats {
            display: flex;
            gap: 48px;
            margin-top: 48px;
            animation: slideUp 1s ease-out 0.6s both;
        }

        .stat-item {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .stat-value {
            font-family: 'Syne', sans-serif;
            font-size: 36px;
            font-weight: 700;
            background: linear-gradient(135deg, var(--mint-primary), var(--mint-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .stat-label {
            font-size: 14px;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .features {
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .feature-badge {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            background: rgba(0, 217, 163, 0.1);
            border: 1px solid rgba(0, 217, 163, 0.2);
            border-radius: 12px;
            font-size: 14px;
            color: var(--mint-light);
            transition: all 0.3s ease;
            animation: slideUp 1s ease-out both;
        }

        .feature-badge:nth-child(1) { animation-delay: 0.8s; }
        .feature-badge:nth-child(2) { animation-delay: 1s; }
        .feature-badge:nth-child(3) { animation-delay: 1.2s; }

        .feature-badge:hover {
            background: rgba(0, 217, 163, 0.15);
            border-color: var(--mint-primary);
            transform: translateX(8px);
        }

        .feature-icon {
            font-size: 20px;
        }

        /* Right Side - Form */
        .form-side {
            padding: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-y: auto;
        }

        .form-container {
            width: 100%;
            max-width: 440px;
            animation: fadeIn 1s ease-out 0.4s both;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .form-header {
            margin-top: 150px;
        }

        .form-header h2 {
            font-family: 'Syne', sans-serif;
            font-size: 42px;
            font-weight: 700;
            color: var(--text-light);
        }

        .form-header p {
            font-size: 16px;
            color: var(--text-muted);
        }

        .status-message {
            padding: 16px 20px;
            background: rgba(0, 217, 163, 0.1);
            border-left: 4px solid var(--mint-primary);
            border-radius: 12px;
            color: var(--mint-light);
            margin-bottom: 24px;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 24px;
            position: relative;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: var(--text-light);
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .input-wrapper {
            position: relative;
        }

        .form-group input {
            width: 100%;
            padding: 16px 20px;
            background: rgba(255, 255, 255, 0.05);
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 14px;
            font-size: 16px;
            color: var(--text-light);
            transition: all 0.3s ease;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .form-group input::placeholder {
            color: var(--text-muted);
        }

        .form-group input:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.08);
            border-color: var(--mint-primary);
            box-shadow: 0 0 0 4px rgba(0, 217, 163, 0.1);
        }

        .toggle-password {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            font-size: 20px;
            padding: 4px;
            transition: color 0.3s ease;
        }

        .toggle-password:hover {
            color: var(--mint-primary);
        }

        .password-strength {
            margin-top: 12px;
            height: 4px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
            overflow: hidden;
            display: none;
        }

        .password-strength.show {
            display: block;
        }

        .password-strength-bar {
            height: 100%;
            width: 0%;
            transition: all 0.4s ease;
            border-radius: 4px;
        }

        .password-strength-bar.weak {
            width: 33%;
            background: var(--accent-coral);
        }

        .password-strength-bar.medium {
            width: 66%;
            background: var(--accent-yellow);
        }

        .password-strength-bar.strong {
            width: 100%;
            background: var(--mint-primary);
        }

        .password-requirements {
            margin-top: 16px;
            padding: 20px;
            background: rgba(255, 230, 109, 0.05);
            border: 1px solid rgba(255, 230, 109, 0.2);
            border-radius: 14px;
            font-size: 13px;
            display: none;
        }

        .password-requirements.show {
            display: block;
        }

        .password-requirements p {
            color: var(--accent-yellow);
            font-weight: 600;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .requirement-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .requirement-item {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--text-muted);
            transition: all 0.3s ease;
        }

        .requirement-item.met {
            color: var(--mint-light);
        }

        .requirement-item .icon {
            font-weight: bold;
            font-size: 16px;
        }

        .requirement-item .icon::before {
            content: '○';
        }

        .requirement-item.met .icon::before {
            content: '✓';
        }

        .error-message {
            color: var(--accent-coral);
            font-size: 13px;
            margin-top: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .checkbox-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 32px;
            flex-wrap: wrap;
            gap: 16px;
        }

        .checkbox-wrapper {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .checkbox-wrapper input[type="checkbox"] {
            width: 20px;
            height: 20px;
            accent-color: var(--mint-primary);
            cursor: pointer;
        }

        .checkbox-wrapper label {
            font-size: 14px;
            color: var(--text-muted);
            margin: 0;
            text-transform: none;
            letter-spacing: normal;
            font-weight: 400;
            cursor: pointer;
        }

        .forgot-link {
            font-size: 14px;
            color: var(--mint-primary);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .forgot-link:hover {
            color: var(--mint-light);
            text-decoration: underline;
        }

        .button-group {
            display: flex;
            gap: 16px;
        }

        .btn {
            flex: 1;
            padding: 16px 32px;
            border-radius: 14px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            font-family: 'Plus Jakarta Sans', sans-serif;
            text-align: center;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--mint-primary), var(--mint-secondary));
            color: var(--bg-dark);
            box-shadow: 0 8px 24px rgba(0, 217, 163, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(0, 217, 163, 0.4);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-secondary {
            background: transparent;
            color: var(--mint-primary);
            border: 2px solid rgba(0, 217, 163, 0.3);
        }

        .btn-secondary:hover {
            background: rgba(0, 217, 163, 0.1);
            border-color: var(--mint-primary);
            transform: translateY(-2px);
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .login-container {
                grid-template-columns: 1fr;
                width: 95%;
                max-width: 600px;
            }

            .brand-side {
                display: none;
            }

            .form-side {
                padding: 60px 40px;
            }
        }

        @media (max-width: 640px) {
            .form-side {
                padding: 40px 24px;
            }

            .form-header h2 {
                font-size: 32px;
                margin-top: 20px;
            }

            .form-group input {
                padding: 14px 16px;
                font-size: 16px;
            }

            .button-group {
                flex-direction: column;
            }

            .checkbox-row {
                flex-direction: column;
                align-items: flex-start;
            }
        }

        @media (max-height: 700px) and (orientation: landscape) {
            .login-container {
                height: 95vh;
            }

            .brand-side,
            .form-side {
                padding: 40px;
            }

            .brand-content h1 {
                font-size: 42px;
            }

            .form-header h2 {
                font-size: 32px;
            }

            .form-header {
                margin-bottom: 32px;
            }

            .stats {
                display: none;
            }
        }
        div::-webkit-scrollbar{
            display: none;
        }
    </style>

    <div class="login-wrapper">
        <!-- Animated Background -->
        <div class="bg-animation">
            <div class="gradient-orb orb-1"></div>
            <div class="gradient-orb orb-2"></div>
            <div class="gradient-orb orb-3"></div>
            <div class="noise-overlay"></div>
        </div>

        <div class="login-container">
            <!-- Left Side - Brand -->
            <div class="brand-side">
                <div class="logo-section">
                    <div class="logo">
                        <div class="logo-icon">✦</div>
                        <span class="logo-text">{{ config('app.name', 'Aurora') }}</span>
                    </div>

                    <div class="brand-content">
                        <h1>Transform Your Fitness Journey with AI</h1>
                        <p>Join thousands of fitness enthusiasts who trust Pathfit AI to achieve their goals, track progress, and stay motivated with personalized workouts and insights.</p>

                        <div class="stats">
                            <div class="stat-item">
                                <div class="stat-value">10K+</div>
                                <div class="stat-label">Active Users</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-value">AI-Powered</div>
                                <div class="stat-label">Workouts</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-value">24/7</div>
                                <div class="stat-label">Support</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="features">
                    <div class="feature-badge">
                        <span class="feature-icon">⚡</span>
                        <span>Lightning-fast performance</span>
                    </div>
                    <div class="feature-badge">
                        <span class="feature-icon">🔒</span>
                        <span>Enterprise-grade security</span>
                    </div>
                    <div class="feature-badge">
                        <span class="feature-icon">🌐</span>
                        <span>Global accessibility</span>
                    </div>
                </div>
            </div>

            <!-- Right Side - Form -->
            <div class="form-side">
                <div class="form-container">
                    <div class="form-header">
                        <h2>Join Pathfit AI</h2>
                        <p>Create your account to start your fitness journey</p>
                    </div>

                    @if (session('status'))
                        <div class="status-message">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register.post') }}">
                        @csrf

                        <!-- Name -->
                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input
                                id="name"
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                placeholder="Enter your full name"
                                required
                                autofocus
                                autocomplete="name"
                            />
                            @error('name')
                                <div class="error-message">⚠ {{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="you@example.com"
                                required
                                autocomplete="username"
                            />
                            @error('email')
                                <div class="error-message">⚠ {{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="form-group">
                            <label for="password">Password</label>
                            <div class="input-wrapper">
                                <input
                                    id="password"
                                    type="password"
                                    name="password"
                                    placeholder="Create a strong password"
                                    required
                                    autocomplete="new-password"
                                    oninput="checkPasswordStrength(this.value)"
                                    onfocus="showPasswordRequirements()"
                                />
                                <button type="button" class="toggle-password" onclick="togglePassword()">
                                    <span id="toggle-icon">👁️</span>
                                </button>
                            </div>

                            <div class="password-strength" id="password-strength">
                                <div class="password-strength-bar" id="strength-bar"></div>
                            </div>

                            <div class="password-requirements" id="password-requirements">
                                <p>⚠️ Password Requirements</p>
                                <ul class="requirement-list">
                                    <li class="requirement-item" id="req-length">
                                        <span class="icon"></span>
                                        <span>At least 8 characters</span>
                                    </li>
                                    <li class="requirement-item" id="req-uppercase">
                                        <span class="icon"></span>
                                        <span>One uppercase letter</span>
                                    </li>
                                    <li class="requirement-item" id="req-lowercase">
                                        <span class="icon"></span>
                                        <span>One lowercase letter</span>
                                    </li>
                                    <li class="requirement-item" id="req-number">
                                        <span class="icon"></span>
                                        <span>One number</span>
                                    </li>
                                    <li class="requirement-item" id="req-special">
                                        <span class="icon"></span>
                                        <span>One special character</span>
                                    </li>
                                </ul>
                            </div>

                            @error('password')
                                <div class="error-message">⚠ {{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password</label>
                            <input
                                id="password_confirmation"
                                type="password"
                                name="password_confirmation"
                                placeholder="Confirm your password"
                                required
                                autocomplete="new-password"
                            />
                            @error('password_confirmation')
                                <div class="error-message">⚠ {{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Terms & Sign In Link -->
                        <div class="checkbox-row">
                            <div class="checkbox-wrapper">
                                <input id="terms" type="checkbox" name="terms" required>
                                <label for="terms">I agree to the Terms & Conditions</label>
                            </div>

                            @if (Route::has('login'))
                                <a href="{{ route('login') }}" class="forgot-link">
                                    Already have an account? Sign in
                                </a>
                            @endif
                        </div>

                        <!-- Buttons -->
                        <div class="button-group">
                            <button type="submit" class="btn btn-primary">
                                Create Account
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const field = document.getElementById('password');
            const icon = document.getElementById('toggle-icon');

            if (field.type === 'password') {
                field.type = 'text';
                icon.textContent = '👁️‍🗨️';
            } else {
                field.type = 'password';
                icon.textContent = '👁️';
            }
        }

        function showPasswordRequirements() {
            document.getElementById('password-requirements').classList.add('show');
            document.getElementById('password-strength').classList.add('show');
        }

        function checkPasswordStrength(password) {
            const requirements = {
                length: password.length >= 8,
                uppercase: /[A-Z]/.test(password),
                lowercase: /[a-z]/.test(password),
                number: /[0-9]/.test(password),
                special: /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password)
            };

            // Update requirements
            updateRequirement('req-length', requirements.length);
            updateRequirement('req-uppercase', requirements.uppercase);
            updateRequirement('req-lowercase', requirements.lowercase);
            updateRequirement('req-number', requirements.number);
            updateRequirement('req-special', requirements.special);

            // Update strength bar
            const metCount = Object.values(requirements).filter(Boolean).length;
            const bar = document.getElementById('strength-bar');

            bar.className = 'password-strength-bar';
            if (password.length === 0) {
                bar.className = 'password-strength-bar';
            } else if (metCount <= 2) {
                bar.classList.add('weak');
            } else if (metCount <= 4) {
                bar.classList.add('medium');
            } else {
                bar.classList.add('strong');
            }
        }

        function updateRequirement(id, met) {
            const element = document.getElementById(id);
            if (met) {
                element.classList.add('met');
            } else {
                element.classList.remove('met');
            }
        }

        // Hide requirements on outside click
        document.addEventListener('click', function(e) {
            const field = document.getElementById('password');
            const requirements = document.getElementById('password-requirements');

            if (!field.contains(e.target) && !requirements.contains(e.target)) {
                const password = field.value;
                if (password.length === 0 || isStrong(password)) {
                    requirements.classList.remove('show');
                    document.getElementById('password-strength').classList.remove('show');
                }
            }
        });

        function isStrong(password) {
            return password.length >= 8 &&
                   /[A-Z]/.test(password) &&
                   /[a-z]/.test(password) &&
                   /[0-9]/.test(password) &&
                   /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password);
        }
    </script>
</x-guest-layout>
