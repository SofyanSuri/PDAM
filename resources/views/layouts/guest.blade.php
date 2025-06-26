<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            :root {
                --primary-blue: #2563eb;
                --soft-blue: #3b82f6;
                --light-blue: #dbeafe;
                --pale-blue: #eff6ff;
                --broken-white: #fafafa;
                --text-dark: #1e293b;
                --text-muted: #64748b;
                --border-color: #e2e8f0;
                --glass-bg: rgba(255, 255, 255, 0.85);
            }

            body {
                background: linear-gradient(135deg, var(--broken-white) 0%, var(--pale-blue) 100%);
                font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
                position: relative;
                overflow-x: hidden;
            }

            /* Floating background elements */
            .bg-decorations {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                pointer-events: none;
                z-index: 0;
            }

            .floating-shape {
                position: absolute;
                border-radius: 50%;
                background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(37, 99, 235, 0.05) 100%);
                animation: float 25s infinite ease-in-out;
            }

            .shape-1 {
                width: 200px;
                height: 200px;
                top: 10%;
                right: 10%;
                animation-delay: 0s;
            }

            .shape-2 {
                width: 150px;
                height: 150px;
                bottom: 20%;
                left: 5%;
                animation-delay: -8s;
            }

            .shape-3 {
                width: 100px;
                height: 100px;
                top: 60%;
                right: 25%;
                animation-delay: -15s;
            }

            .shape-4 {
                width: 80px;
                height: 80px;
                top: 30%;
                left: 20%;
                animation-delay: -20s;
            }

            @keyframes float {
                0%, 100% { 
                    transform: translateY(0px) translateX(0px) rotate(0deg);
                    opacity: 0.3;
                }
                25% { 
                    transform: translateY(-20px) translateX(10px) rotate(90deg);
                    opacity: 0.6;
                }
                50% { 
                    transform: translateY(15px) translateX(-15px) rotate(180deg);
                    opacity: 0.4;
                }
                75% { 
                    transform: translateY(-10px) translateX(5px) rotate(270deg);
                    opacity: 0.5;
                }
            }

            /* Main container styling */
            .main-container {
                position: relative;
                z-index: 1;
                min-height: 100vh;
                padding: 1.5rem 0;
            }

            /* Logo container */
            .logo-container {
                margin-bottom: 2rem;
                animation: fadeInDown 0.8s ease-out;
            }

            .logo-wrapper {
                display: inline-flex;
                align-items: center;
                gap: 0.75rem;
                padding: 1rem 1.5rem;
                background: var(--glass-bg);
                backdrop-filter: blur(15px);
                border-radius: 20px;
                border: 1px solid var(--border-color);
                box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
                transition: all 0.3s ease;
            }

            .logo-wrapper:hover {
                transform: translateY(-5px);
                box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
            }

            .logo-icon {
                font-size: 2rem;
                color: var(--primary-blue);
            }

            .logo-text {
                font-size: 1.75rem;
                font-weight: 700;
                color: var(--primary-blue);
                letter-spacing: -0.025em;
            }

            /* Form container */
            .form-container {
                background: var(--glass-bg);
                backdrop-filter: blur(20px);
                border-radius: 24px;
                border: 1px solid var(--border-color);
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
                padding: 2.5rem;
                width: 100%;
                max-width: 28rem;
                position: relative;
                overflow: hidden;
                animation: fadeInUp 0.8s ease-out 0.2s both;
            }

            .form-container::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 4px;
                background: linear-gradient(135deg, var(--primary-blue) 0%, var(--soft-blue) 100%);
                border-radius: 24px 24px 0 0;
            }

            /* Form elements styling */
            .form-container input {
                background: rgba(255, 255, 255, 0.9);
                border: 1px solid var(--border-color);
                border-radius: 12px;
                padding: 0.875rem 1rem;
                transition: all 0.2s ease;
                font-size: 0.95rem;
            }

            .form-container input:focus {
                outline: none;
                border-color: var(--soft-blue);
                box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
                background: rgba(255, 255, 255, 1);
            }

            .form-container label {
                color: var(--text-dark);
                font-weight: 500;
                font-size: 0.875rem;
                margin-bottom: 0.5rem;
            }

            /* Button styling */
            .form-container button {
                background: linear-gradient(135deg, var(--primary-blue) 0%, var(--soft-blue) 100%);
                border: none;
                border-radius: 12px;
                padding: 0.875rem 1.5rem;
                font-weight: 600;
                font-size: 0.95rem;
                color: white;
                transition: all 0.2s ease;
                width: 100%;
                position: relative;
                overflow: hidden;
            }

            .form-container button:hover {
                background: linear-gradient(135deg, var(--soft-blue) 0%, var(--primary-blue) 100%);
                transform: translateY(-2px);
                box-shadow: 0 8px 25px rgba(37, 99, 235, 0.3);
            }

            .form-container button:active {
                transform: translateY(0);
            }

            /* Link styling */
            .form-container a {
                color: var(--primary-blue);
                text-decoration: none;
                font-weight: 500;
                transition: all 0.2s ease;
            }

            .form-container a:hover {
                color: var(--soft-blue);
                text-decoration: underline;
            }

            /* Error messages */
            .form-container .text-red-600 {
                color: #dc2626 !important;
                font-size: 0.875rem;
                margin-top: 0.25rem;
            }

            /* Checkbox styling */
            .form-container input[type="checkbox"] {
                accent-color: var(--primary-blue);
                width: 1rem;
                height: 1rem;
            }

            /* Animations */
            @keyframes fadeInDown {
                from {
                    opacity: 0;
                    transform: translateY(-30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            /* Responsive design */
            @media (max-width: 640px) {
                .form-container {
                    margin: 0 1rem;
                    padding: 2rem 1.5rem;
                }
                
                .logo-text {
                    font-size: 1.5rem;
                }
                
                .main-container {
                    padding: 1rem 0;
                }
            }

            /* Text color overrides for Tailwind compatibility */
            .text-gray-900 {
                color: var(--text-dark) !important;
            }

            .text-gray-500 {
                color: var(--text-muted) !important;
            }

            .bg-gray-100 {
                background: transparent !important;
            }

            .bg-white {
                background: transparent !important;
            }

            .shadow-md {
                box-shadow: none !important;
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <!-- Background decorations -->
        <div class="bg-decorations">
            <div class="floating-shape shape-1"></div>
            <div class="floating-shape shape-2"></div>
            <div class="floating-shape shape-3"></div>
            <div class="floating-shape shape-4"></div>
        </div>

        <div class="main-container flex flex-col sm:justify-center items-center">
            <div class="logo-container">
                <a href="/">
                    <div class="logo-wrapper">
                        <div class="logo-icon">
                            <img src="{{ asset('assets/images/logo.png') }}" style="width: 50px; height: auto;" alt="Logo">
                        </div>
                        <div class="logo-text">PDAM</div>
                    </div>
                </a>
            </div>

            <div class="form-container">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>