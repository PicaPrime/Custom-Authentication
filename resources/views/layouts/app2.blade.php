<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'Laravel Blog') }} - @yield('title', 'Home')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        :root {
            --primary-color: #4f46e5;
            --secondary-color: #6b7280;
            --success-color: #10b981;
            --danger-color: #ef4444;
            --warning-color: #f59e0b;
            --info-color: #3b82f6;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: #f9fafb;
        }
        
        .navbar {
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
        }
        
        .navbar-brand {
            font-weight: 600;
            color: var(--primary-color) !important;
        }
        
        .role-badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
            font-weight: 500;
            text-transform: uppercase;
        }
        
        .role-admin { background-color: #fee2e2; color: #dc2626; }
        .role-editor { background-color: #dbeafe; color: #2563eb; }
        .role-author { background-color: #d1fae5; color: #059669; }
        
        .card {
            border: 1px solid #e5e7eb;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        .card:hover {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
        .status-badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-weight: 500;
        }
        
        .status-published { background-color: #d1fae5; color: #059669; }
        .status-draft { background-color: #f3f4f6; color: #6b7280; }
        .status-archived { background-color: #fef3c7; color: #d97706; }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: #4338ca;
            border-color: #4338ca;
        }
        
        .alert {
            border: none;
            border-radius: 0.5rem;
        }
        
        .breadcrumb {
            background-color: transparent;
            padding: 0;
            margin-bottom: 1.5rem;
        }
        
        .breadcrumb-item + .breadcrumb-item::before {
            content: "›";
            color: #9ca3af;
        }
        
        .table {
            background-color: white;
            border-radius: 0.5rem;
            overflow: hidden;
        }
        
        .table thead th {
            background-color: #f9fafb;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            color: #6b7280;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .post-content {
            font-size: 1.125rem;
            line-height: 1.75;
            color: #374151;
        }
        
        .post-meta {
            color: #6b7280;
            font-size: 0.875rem;
        }
        
        .footer {
            background-color: white;
            border-top: 1px solid #e5e7eb;
            margin-top: auto;
        }
    </style>
    
    @stack('styles')
</head>
<body class="d-flex flex-column min-vh-100">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="bi bi-journal-text"></i> {{ config('app.name', 'Laravel Blog') }}
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('posts.index') ? 'active' : '' }}" href="{{ route('posts.index') }}">
                            <i class="bi bi-grid"></i> All Posts
                        </a>
                    </li>
                    @auth
                        @can('create', App\Models\Post::class)
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('posts.create') ? 'active' : '' }}" href="{{ route('posts.create') }}">
                                <i class="bi bi-plus-circle"></i> New Post
                            </a>
                        </li>
                        @endcan
                    @endauth
                </ul>
                
                <ul class="navbar-nav">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-2"></i>
                                {{ Auth::user()->name }}
                                <span class="role-badge role-{{ Auth::user()->role }} ms-2">
                                    {{ Auth::user()->role }}
                                </span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="{{ route('posts.index') }}?user={{ Auth::id() }}">
                                        <i class="bi bi-file-text"></i> My Posts
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="bi bi-box-arrow-right"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Register</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Main Content -->
    <main class="flex-grow-1 py-4">
        @yield('content')
    </main>
    
    <!-- Footer -->
    <footer class="footer py-3 mt-5">
        <div class="container">
            <div class="text-center text-muted">
                <small>&copy; {{ date('Y') }} {{ config('app.name', 'Laravel Blog') }}. All rights reserved.</small>
            </div>
        </div>
    </footer>
    
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>