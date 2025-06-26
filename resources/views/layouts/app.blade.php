<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - PDAM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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
        }

        body {
            background: linear-gradient(135deg, var(--broken-white) 0%, var(--pale-blue) 100%);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--text-dark);
            min-height: 100vh;
        }

        .navbar {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--border-color);
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        }

        .navbar-brand {
            color: var(--primary-blue) !important;
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: -0.025em;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .navbar-brand::before {
            content: '';
            font-size: 1.25rem;
        }

        .user-info {
            background: var(--light-blue);
            color: var(--primary-blue);
            padding: 0.375rem 0.75rem;
            border-radius: 50px;
            font-size: 0.875rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .user-info i {
            opacity: 0.7;
        }

        .btn-logout {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            border: none;
            color: white;
            padding: 0.375rem 1rem;
            border-radius: 50px;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s ease;
            box-shadow: 0 1px 3px 0 rgba(239, 68, 68, 0.3);
        }

        .btn-logout:hover {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px 0 rgba(239, 68, 68, 0.4);
            color: white;
        }

        .btn-logout:active {
            transform: translateY(0);
        }

        main {
            position: relative;
            z-index: 1;
        }

        .container {
            max-width: 1200px;
        }

        /* Content wrapper styling */
        .content-wrapper {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            border: 1px solid var(--border-color);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            padding: 2rem;
            margin: 2rem 0;
        }

        /* Custom card styling */
        .card {
            border: none;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            transition: all 0.2s ease;
        }

        .card:hover {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transform: translateY(-2px);
        }

        /* Button styling */
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--soft-blue) 100%);
            border: none;
            border-radius: 8px;
            font-weight: 500;
            padding: 0.5rem 1.5rem;
            transition: all 0.2s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--soft-blue) 0%, var(--primary-blue) 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px 0 rgba(37, 99, 235, 0.3);
        }

        /* Form styling */
        .form-control {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 0.75rem;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            border-color: var(--soft-blue);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        /* Floating elements */
        .floating-shape {
            position: fixed;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(37, 99, 235, 0.05) 100%);
            z-index: 0;
            animation: float 20s infinite linear;
        }

        .floating-shape:nth-child(1) {
            width: 100px;
            height: 100px;
            top: 10%;
            right: 10%;
            animation-delay: 0s;
        }

        .floating-shape:nth-child(2) {
            width: 150px;
            height: 150px;
            bottom: 20%;
            left: 5%;
            animation-delay: -10s;
        }

        .floating-shape:nth-child(3) {
            width: 80px;
            height: 80px;
            top: 60%;
            right: 20%;
            animation-delay: -5s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            33% { transform: translateY(-20px) rotate(120deg); }
            66% { transform: translateY(10px) rotate(240deg); }
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .navbar-brand {
                font-size: 1.25rem;
            }
            
            .content-wrapper {
                margin: 1rem 0;
                padding: 1.5rem;
            }
            
            .user-info {
                display: none;
            }
        }
    </style>
</head>
<body>
    <!-- Floating background shapes -->
    <div class="floating-shape"></div>
    <div class="floating-shape"></div>
    <div class="floating-shape"></div>

    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="{{ asset('assets/images/logo.png') }}" alt="PDAM Logo" style="height: 50px; margin-right: 8px;">
            PDAM
        </a>
            <div class="ms-auto d-flex align-items-center gap-3">
                @auth
                    <div class="user-info d-none d-md-flex">
                        <i class="fas fa-user-circle"></i>
                        <span>Halo, {{ Auth::user()->name }}</span>
                    </div>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-logout">
                            <i class="fas fa-sign-out-alt me-2"></i>
                            Logout
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </nav>

    <main class="py-4">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @stack('scripts')

</body>
</html>