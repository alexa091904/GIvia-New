<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'GIVIA | Premium E-Commerce')</title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL,GRAD,opsz@300,0,0,24&display=swap" rel="stylesheet" />

    @php
        $manifestPath = public_path('build/manifest.json');
        if (file_exists($manifestPath)) {
            $manifest = json_decode(file_get_contents($manifestPath), true);
            $cssFile = $manifest['resources/css/app.css']['file'] ?? null;
            $jsFile = $manifest['resources/js/app.js']['file'] ?? null;
        }
    @endphp
    @if(isset($cssFile))
        <link rel="stylesheet" href="{{ asset('build/' . $cssFile) }}">
    @endif
    @if(isset($jsFile))
        <script type="module" src="{{ asset('build/' . $jsFile) }}"></script>
    @endif

    <style>
        /* Glassmorphism utilities */
        .glass-nav {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(30, 41, 59, 0.05);
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 20px 40px rgba(30, 41, 59, 0.05);
        }

        /* Material Icons Baseline Adjustment */
        .material-symbols-outlined {
            vertical-align: -20%;
        }

        /* Global Toast Animation */
        @keyframes slideUp {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .toast-animate {
            animation: slideUp 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased flex flex-col min-h-screen">

    <!-- Global Toast Container -->
    <div id="toast-container" class="fixed bottom-6 right-6 z-[100] flex flex-col gap-3 pointer-events-none"></div>

    <!-- Navigation Header -->
    <header class="fixed top-0 w-full z-50 transition-all duration-300" id="main-nav">
        <div class="glass-nav absolute inset-0 transition-opacity duration-300" id="nav-bg" style="opacity: 0;"></div>
        <div class="relative max-w-[1280px] mx-auto px-6 h-20 flex items-center justify-between">
            
            <!-- Logo -->
            <a href="/" class="flex items-center gap-2 z-10 group">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-primary-600 to-purple-500 flex items-center justify-center text-white shadow-glow group-hover:scale-105 transition-transform">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">auto_awesome</span>
                </div>
                <span class="text-2xl font-bold tracking-tight text-slate-900">Givia</span>
            </a>

            <!-- Desktop Links -->
            <nav class="hidden md:flex items-center gap-8 z-10">
                <a href="/" class="text-sm font-medium {{ request()->is('/') ? 'text-primary-600' : 'text-slate-600 hover:text-primary-600' }} transition-colors">Home</a>
                <a href="{{ route('products.index') }}" class="text-sm font-medium {{ request()->routeIs('products.*') ? 'text-primary-600' : 'text-slate-600 hover:text-primary-600' }} transition-colors">Shop</a>
                <a href="/about" class="text-sm font-medium {{ request()->is('about*') ? 'text-primary-600' : 'text-slate-600 hover:text-primary-600' }} transition-colors">About</a>
            </nav>

            <!-- Actions -->
            <div class="flex items-center gap-4 z-10">
                <!-- Search Icon -->
                <button id="search-toggle" onclick="toggleSearch()" class="p-2 text-slate-600 hover:text-primary-600 transition-colors" aria-label="Search">
                    <span class="material-symbols-outlined">search</span>
                </button>

                <!-- User/Auth -->
                @auth
                    <div class="relative group">
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-2 p-2 text-slate-600 hover:text-primary-600 transition-colors">
                            <div class="w-8 h-8 rounded-full bg-slate-200 border border-slate-300 overflow-hidden">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=e0e7ff&color=4f46e5" alt="Profile" class="w-full h-full object-cover">
                            </div>
                        </a>
                        <!-- Dropdown (Hover) -->
                        <div class="absolute right-0 top-full mt-2 w-48 bg-white rounded-xl shadow-glass border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all transform origin-top-right scale-95 group-hover:scale-100">
                            <div class="p-2">
                                <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-primary-600 rounded-lg">My Account</a>
                                <a href="{{ route('orders.index') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-primary-600 rounded-lg">My Orders</a>
                                @if(Auth::user()->role === 'admin')
                                    <div class="h-px bg-slate-100 my-1"></div>
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-primary-600 font-semibold hover:bg-primary-50 rounded-lg">Admin Panel</a>
                                @endif
                                <div class="h-px bg-slate-100 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-rose-600 hover:bg-rose-50 rounded-lg">Logout</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-medium text-slate-600 hover:text-primary-600 transition-colors hidden sm:block">Log in</a>
                    <a href="{{ route('register') }}" class="text-sm font-medium bg-slate-900 text-white px-5 py-2.5 rounded-lg hover:bg-primary-600 transition-colors shadow-sm hidden sm:block">Sign up</a>
                @endauth

                <!-- Cart -->
                <a href="/cart" class="relative p-2 text-slate-600 hover:text-primary-600 transition-colors">
                    <span class="material-symbols-outlined">local_mall</span>
                    <span id="cart-count-badge" class="absolute top-1 right-0 w-4 h-4 bg-primary-600 text-white text-[9px] font-bold items-center justify-center rounded-full border-2 border-white shadow-sm hidden">0</span>
                </a>
                
                <!-- Mobile Menu Toggle -->
                <button id="mobile-menu-btn" onclick="toggleMobileMenu()" class="md:hidden p-2 text-slate-600">
                    <span class="material-symbols-outlined" id="mobile-menu-icon">menu</span>
                </button>
            </div>
        </div>
        
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden glass-nav border-t border-slate-100">
            <nav class="flex flex-col px-6 py-4 gap-1">
                <a href="/" class="text-sm font-medium py-3 {{ request()->is('/') ? 'text-primary-600' : 'text-slate-600' }} border-b border-slate-100">Home</a>
                <a href="{{ route('products.index') }}" class="text-sm font-medium py-3 {{ request()->routeIs('products.*') ? 'text-primary-600' : 'text-slate-600' }} border-b border-slate-100">Shop</a>
                <a href="/about" class="text-sm font-medium py-3 {{ request()->is('about*') ? 'text-primary-600' : 'text-slate-600' }} border-b border-slate-100">About</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="text-sm font-medium py-3 text-slate-600 border-b border-slate-100">My Account</a>
                    <a href="{{ route('orders.index') }}" class="text-sm font-medium py-3 text-slate-600 border-b border-slate-100">My Orders</a>
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="text-sm font-semibold py-3 text-primary-600 border-b border-slate-100">Admin Panel</a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="text-sm font-medium py-3 text-slate-600 border-b border-slate-100">Log in</a>
                    <a href="{{ route('register') }}" class="text-sm font-medium py-3 text-primary-600">Sign up</a>
                @endauth
            </nav>
        </div>
    </header>

    <!-- Global Search Modal -->
    <div id="search-modal" class="fixed inset-0 z-[100] hidden items-start justify-center pt-24 px-4" onclick="if(event.target===this) toggleSearch()">
        <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm"></div>
        <div class="relative w-full max-w-2xl bg-white rounded-2xl shadow-2xl overflow-hidden border border-slate-100">
            <form action="{{ route('products.index') }}" method="GET" class="flex items-center gap-3 p-4">
                <span class="material-symbols-outlined text-slate-400 flex-shrink-0">search</span>
                <input id="search-input" type="text" name="search" placeholder="Search for products…" autocomplete="off"
                    class="flex-1 text-base text-slate-800 placeholder:text-slate-400 outline-none bg-transparent py-1"
                    value="{{ request('search') }}">
                <button type="button" onclick="toggleSearch()" class="flex-shrink-0 p-1 text-slate-400 hover:text-slate-600 transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </form>
            <div class="border-t border-slate-100 px-4 py-3 flex items-center gap-4 text-xs text-slate-400">
                <span>Press <kbd class="px-1.5 py-0.5 bg-slate-100 rounded text-slate-600 font-mono">Enter</kbd> to search</span>
                <span>Press <kbd class="px-1.5 py-0.5 bg-slate-100 rounded text-slate-600 font-mono">Esc</kbd> to close</span>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Global Footer -->
    <footer class="bg-white border-t border-slate-100 pt-16 pb-8 mt-24">
        <div class="max-w-[1280px] mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <div class="col-span-1 md:col-span-1">
                    <a href="/" class="flex items-center gap-2 mb-6">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-primary-600 to-purple-500 flex items-center justify-center text-white">
                            <span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' 1;">auto_awesome</span>
                        </div>
                        <span class="text-xl font-bold tracking-tight text-slate-900">Givia</span>
                    </a>
                    <p class="text-sm text-slate-500 leading-relaxed">
                        Curating premium experiences through exceptional products. Elevated design for modern living.
                    </p>
                </div>
                <div>
                    <h4 class="font-semibold text-slate-900 mb-6 uppercase text-xs tracking-wider">Shop</h4>
                    <ul class="space-y-4">
                        <li><a href="#" class="text-sm text-slate-500 hover:text-primary-600 transition-colors">New Arrivals</a></li>
                        <li><a href="#" class="text-sm text-slate-500 hover:text-primary-600 transition-colors">Bestsellers</a></li>
                        <li><a href="#" class="text-sm text-slate-500 hover:text-primary-600 transition-colors">Categories</a></li>
                        <li><a href="#" class="text-sm text-slate-500 hover:text-primary-600 transition-colors">Sale</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-slate-900 mb-6 uppercase text-xs tracking-wider">Support</h4>
                    <ul class="space-y-4">
                        <li><a href="#" class="text-sm text-slate-500 hover:text-primary-600 transition-colors">Contact Us</a></li>
                        <li><a href="#" class="text-sm text-slate-500 hover:text-primary-600 transition-colors">FAQs</a></li>
                        <li><a href="#" class="text-sm text-slate-500 hover:text-primary-600 transition-colors">Shipping & Returns</a></li>
                        <li><a href="#" class="text-sm text-slate-500 hover:text-primary-600 transition-colors">Track Order</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-slate-900 mb-6 uppercase text-xs tracking-wider">Newsletter</h4>
                    <p class="text-sm text-slate-500 mb-4">Subscribe to receive updates, access to exclusive deals, and more.</p>
                    <form class="flex relative">
                        <input type="email" placeholder="Enter your email" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-3 text-sm focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition-all">
                        <button type="submit" class="absolute right-1 top-1 bottom-1 px-4 bg-slate-900 text-white rounded-md text-sm font-medium hover:bg-primary-600 transition-colors">Subscribe</button>
                    </form>
                </div>
            </div>
            <div class="border-t border-slate-100 pt-8 flex flex-col md:flex-row items-center justify-between gap-4">
                <p class="text-xs text-slate-400">&copy; {{ date('Y') }} Givia Store. All rights reserved.</p>
                <div class="flex items-center gap-4">
                    <a href="#" class="text-slate-400 hover:text-primary-600 transition-colors"><span class="material-symbols-outlined text-[20px]">language</span></a>
                    <a href="#" class="text-slate-400 hover:text-primary-600 transition-colors"><span class="material-symbols-outlined text-[20px]">share</span></a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Global Scripts -->
    <script>
        // Scroll Header Effect
        window.addEventListener('scroll', () => {
            const navBg = document.getElementById('nav-bg');
            if (window.scrollY > 20) {
                navBg.style.opacity = '1';
                document.getElementById('main-nav').classList.add('shadow-sm');
            } else {
                navBg.style.opacity = '0';
                document.getElementById('main-nav').classList.remove('shadow-sm');
            }
        });

        // Global Toast Function
        window.showToast = function(message, type = 'success') {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            toast.className = `toast-animate pointer-events-auto flex items-center gap-3 px-5 py-4 rounded-xl shadow-glass border bg-white ${
                type === 'success' ? 'border-emerald-100' : 
                type === 'error' ? 'border-rose-100' : 'border-slate-100'
            }`;
            
            const icon = type === 'success' ? 'check_circle' : (type === 'error' ? 'error' : 'info');
            const colorClass = type === 'success' ? 'text-emerald-500' : (type === 'error' ? 'text-rose-500' : 'text-primary-500');
            
            toast.innerHTML = `
                <span class="material-symbols-outlined ${colorClass}">${icon}</span>
                <p class="text-sm font-medium text-slate-700">${message}</p>
            `;
            
            container.appendChild(toast);
            
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateY(10px)';
                toast.style.transition = 'all 0.3s ease';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        };

        // Initialize Cart Counter
        function updateCartCounter() {
            fetch('/cart/count')
                .then(res => res.json())
                .then(data => {
                    const badge = document.getElementById('cart-count-badge');
                    if (data.count > 0) {
                        badge.textContent = data.count > 99 ? '99+' : data.count;
                        badge.classList.remove('hidden');
                        badge.classList.add('inline-flex');
                    } else {
                        badge.classList.add('hidden');
                        badge.classList.remove('inline-flex');
                    }
                })
                .catch(e => console.error('Error fetching cart count:', e));
        }

        // Run on load
        document.addEventListener('DOMContentLoaded', updateCartCounter);
        
        // Poll cart count every 30 seconds to keep badge in sync
        setInterval(updateCartCounter, 30000);

        // Search Modal
        window.toggleSearch = function() {
            const modal = document.getElementById('search-modal');
            const isHidden = modal.classList.contains('hidden');
            if (isHidden) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.style.overflow = 'hidden';
                setTimeout(() => document.getElementById('search-input').focus(), 50);
            } else {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.style.overflow = '';
            }
        };

        // Close search on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const modal = document.getElementById('search-modal');
                if (!modal.classList.contains('hidden')) toggleSearch();
            }
        });

        // Mobile Menu
        window.toggleMobileMenu = function() {
            const menu = document.getElementById('mobile-menu');
            const icon = document.getElementById('mobile-menu-icon');
            const isHidden = menu.classList.contains('hidden');
            menu.classList.toggle('hidden', !isHidden);
            icon.textContent = isHidden ? 'close' : 'menu';
        };
    </script>
    
    <!-- Session Toasts -->
    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', () => showToast("{{ session('success') }}", 'success'));
        </script>
    @endif
    
    @if(session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', () => showToast("{{ session('error') }}", 'error'));
        </script>
    @endif

    @stack('scripts')
</body>
</html>