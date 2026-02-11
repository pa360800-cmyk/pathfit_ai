<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'PathFit') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            height: 100vh;
            overflow: hidden;
        }
        div::-webkit-scrollbar{
            display: none;
        }

        .container {
            display: flex;
            height: 100vh;
        }

        /* Left Side - Branding */
        .left-side {
            flex: 1;
            background: linear-gradient(135deg, #5fdfd8 0%, #0d8686 100%);
            padding: 60px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }

        .left-side::before {
            content: '';
            position: absolute;
            top: -200px;
            left: -200px;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .left-side::after {
            content: '';
            position: absolute;
            bottom: -200px;
            right: -200px;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .branding {
            position: relative;
            z-index: 1;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 60px;
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            background: white;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-icon-inner {
            width: 24px;
            height: 24px;
            background: linear-gradient(135deg, #5fdfd8 0%, #0d8686 100%);
            border-radius: 4px;
        }

        .logo-text {
            font-size: 24px;
            font-weight: 700;
            color: white;
        }

        .welcome-text h1 {
            font-size: 48px;
            font-weight: 700;
            color: white;
            line-height: 1.2;
            margin-bottom: 24px;
        }

        .welcome-text p {
            font-size: 18px;
            color: rgba(255, 255, 255, 0.9);
            line-height: 1.6;
            max-width: 500px;
        }

        .testimonial {
            position: relative;
            z-index: 1;
        }

        .testimonial blockquote {
            font-size: 18px;
            font-style: italic;
            color: rgba(255, 255, 255, 0.95);
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .author-avatar {
            width: 48px;
            height: 48px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 16px;
        }

        .author-info {
            display: flex;
            flex-direction: column;
        }

        .author-name {
            color: white;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .author-title {
            color: rgba(255, 255, 255, 0.8);
            font-size: 14px;
        }

        /* Right Side - Login Form */
        .right-side {
            flex: 1;
            background: #f9fafb;
            padding: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-y: auto;
        }

        .form-container {
            width: 100%;
            max-width: 440px;
        }

        .form-header {
            margin-bottom: 40px;
        }

        .form-header h2 {
            font-size: 32px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 8px;
        }

        .form-header p {
            font-size: 16px;
            color: #6b7280;
        }

        .form-header a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }

        .form-header a:hover {
            color: #5568d3;
        }

        .form-group {
            margin-bottom: 24px;
        }

        label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #374151;
            margin-bottom: 8px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            width: 20px;
            height: 20px;
        }

        input[type="email"],
        input[type="password"],
        input[type="text"] {
            width: 100%;
            padding: 12px 12px 12px 44px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.2s;
            outline: none;
        }

        input[type="email"]:focus,
        input[type="password"]:focus,
        input[type="text"]:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #9ca3af;
            cursor: pointer;
            padding: 4px;
            display: flex;
            align-items: center;
        }

        .toggle-password:hover {
            color: #6b7280;
        }

        .form-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        input[type="checkbox"] {
            width: 16px;
            height: 16px;
            cursor: pointer;
        }

        .remember-me label {
            margin: 0;
            font-size: 14px;
            font-weight: 400;
            cursor: pointer;
        }

        .forgot-password {
            font-size: 14px;
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
        }

        .forgot-password:hover {
            color: #5568d3;
        }

        .submit-btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #5fdfd8 0%, #0d8686 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            margin-bottom: 24px;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .divider {
            position: relative;
            text-align: center;
            margin: 32px 0;
        }

        .divider::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            width: 100%;
            height: 1px;
            background: #d1d5db;
        }

        .divider span {
            position: relative;
            background: #f9fafb;
            padding: 0 16px;
            color: #6b7280;
            font-size: 14px;
        }

        .social-login {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .social-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background: white;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            color: #374151;
            transition: background 0.2s;
        }

        .social-btn:hover {
            background: #f3f4f6;
        }

        .social-icon {
            width: 20px;
            height: 20px;
        }

        /* SVG Icons */
        .icon-mail {
            fill: none;
            stroke: currentColor;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .icon-lock {
            fill: none;
            stroke: currentColor;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .icon-eye {
            fill: none;
            stroke: currentColor;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        /* Responsive */
        @media (max-width: 968px) {
            .left-side {
                display: none;
            }

            .right-side {
                padding: 40px 24px;
            }

            .form-header h2 {
                font-size: 28px;
            }
        }

        @media (max-width: 480px) {
            .social-login {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Left Side - Branding -->
        <div class="left-side">
            <div class="branding">
                <div class="logo">
                    <div class="logo-icon">
                        <div class="logo-icon-inner"></div>
                    </div>
                    <span class="logo-text">PathFit</span>
                </div>

                <div class="welcome-text">
                    <h1>Welcome back to your dashboard</h1>
                    <p>Sign in to access your account and continue where you left off. Manage your training with ease.</p>
                </div>
            </div>

            <div class="testimonial">
                <blockquote>"This platform has transformed the way we train. Simple, efficient, and powerful."</blockquote>
                <div class="testimonial-author">
                    <div class="author-avatar">PF</div>
                    <div class="author-info">
                        <div class="author-name">PathFit Team</div>
                        <div class="author-title">Fitness Platform</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="right-side">
            <div class="form-container">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>
</html>
