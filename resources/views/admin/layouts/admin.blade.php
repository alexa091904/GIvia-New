<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('page-title', 'Admin Console') - GIVIA</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    {{-- Tailwind config MUST be defined before the CDN script loads --}}
    <script>
        tailwind = window.tailwind || {};
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "surface": "#fbf8ff",
                        "on-surface": "#1a1b22",
                        "on-surface-variant": "#444653",
                        "outline-variant": "#c5c5d5",
                    },
                    fontFamily: {
                        "display-lg": ["Inter"],
                        "body-base": ["Inter"],
                        "label-sm": ["Inter"],
                        "body-sm": ["Inter"],
                        "title-sm": ["Inter"],
                        "label-bold": ["Inter"],
                        "headline-md": ["Inter"]
                    }
                }
            }
        };
    </script>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <style>
        .custom-gradient-purple {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .custom-gradient-blue {
            background: linear-gradient(135deg, #3a7bd5 0%, #00d2ff 100%);
        }
        .custom-gradient-green {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        }
        .custom-gradient-orange {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        /* Toast Animation */
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        .animate-slideIn {
            animation: slideIn 0.3s ease-out forwards;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-surface font-body-base text-on-surface antialiased">
    <!-- SideNavBar Component -->
    <aside class="fixed left-0 top-0 h-screen w-[280px] border-r bg-white dark:bg-slate-900 border-slate-200 dark:border-slate-800 shadow-[0px_4px_20px_rgba(0,0,0,0.05)] font-['Inter'] antialiased text-sm flex flex-col py-6 z-50">
        <div class="px-6 mb-8 flex items-center gap-3">
            <div class="w-10 h-10 custom-gradient-purple rounded-xl flex items-center justify-center text-white">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">dataset</span>
            </div>
            <div>
                <h1 class="text-2xl font-black tracking-tight text-slate-900 dark:text-white leading-none">Givia</h1>
                <p class="text-xs text-slate-500 font-medium mt-1">Admin Console</p>
            </div>
        </div>
        
        <nav class="flex-1 space-y-1">
            <a class="flex items-center gap-3 px-6 py-3 transition-all {{ request()->routeIs('admin.dashboard') ? 'text-indigo-600 dark:text-indigo-400 bg-indigo-50/50 dark:bg-indigo-900/20 border-l-4 border-indigo-600 font-semibold' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 hover:bg-slate-50' }}" href="{{ route('admin.dashboard') }}">
                <span class="material-symbols-outlined">dashboard</span>
                <span>Dashboard</span>
            </a>
            <a class="flex items-center gap-3 px-6 py-3 transition-all {{ request()->routeIs('admin.products.*') ? 'text-indigo-600 dark:text-indigo-400 bg-indigo-50/50 dark:bg-indigo-900/20 border-l-4 border-indigo-600 font-semibold' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 hover:bg-slate-50' }}" href="{{ route('admin.products.index') }}">
                <span class="material-symbols-outlined">inventory_2</span>
                <span>Products</span>
            </a>
            <a class="flex items-center gap-3 px-6 py-3 transition-all {{ request()->routeIs('admin.orders.*') ? 'text-indigo-600 dark:text-indigo-400 bg-indigo-50/50 dark:bg-indigo-900/20 border-l-4 border-indigo-600 font-semibold' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 hover:bg-slate-50' }}" href="{{ route('admin.orders.index') }}">
                <span class="material-symbols-outlined">shopping_cart</span>
                <span>Orders</span>
            </a>
            <a class="flex items-center gap-3 px-6 py-3 transition-all {{ request()->routeIs('admin.inventory.*') ? 'text-indigo-600 dark:text-indigo-400 bg-indigo-50/50 dark:bg-indigo-900/20 border-l-4 border-indigo-600 font-semibold' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 hover:bg-slate-50' }}" href="{{ route('admin.inventory.index') }}">
                <span class="material-symbols-outlined">storage</span>
                <span>Inventory</span>
            </a>
            <a class="flex items-center gap-3 px-6 py-3 transition-all {{ request()->routeIs('admin.users.*') ? 'text-indigo-600 dark:text-indigo-400 bg-indigo-50/50 dark:bg-indigo-900/20 border-l-4 border-indigo-600 font-semibold' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 hover:bg-slate-50' }}" href="{{ route('admin.users.index') }}">
                <span class="material-symbols-outlined">group</span>
                <span>Users</span>
            </a>
            <a class="flex items-center gap-3 px-6 py-3 transition-all {{ request()->routeIs('admin.reports.*') ? 'text-indigo-600 dark:text-indigo-400 bg-indigo-50/50 dark:bg-indigo-900/20 border-l-4 border-indigo-600 font-semibold' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 hover:bg-slate-50' }}" href="{{ route('admin.reports.index') }}">
                <span class="material-symbols-outlined">bar_chart</span>
                <span>Reports</span>
            </a>
            <a class="flex items-center gap-3 px-6 py-3 transition-all {{ request()->routeIs('admin.settings.*') ? 'text-indigo-600 dark:text-indigo-400 bg-indigo-50/50 dark:bg-indigo-900/20 border-l-4 border-indigo-600 font-semibold' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 hover:bg-slate-50' }}" href="{{ route('admin.settings.index') }}">
                <span class="material-symbols-outlined">settings</span>
                <span>Settings</span>
            </a>
        </nav>
        
        <div class="px-6 mt-auto space-y-4">
            <a href="{{ route('home') }}" class="flex items-center gap-2 text-slate-500 hover:text-indigo-600 transition-colors">
                <span class="material-symbols-outlined text-sm">storefront</span>
                <span class="text-sm font-medium">Back to Store</span>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center gap-2 text-rose-500 hover:text-rose-700 transition-colors w-full text-left">
                    <span class="material-symbols-outlined text-sm">logout</span>
                    <span class="text-sm font-medium">Logout</span>
                </button>
            </form>
            <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 mt-4">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">System Status</p>
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="text-xs font-medium text-slate-700 dark:text-slate-300">Servers Online</span>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Wrapper -->
    <div class="pl-[280px]">
        <!-- TopNavBar Component -->
        <header class="fixed top-0 right-0 w-[calc(100%-280px)] h-16 border-b bg-white/80 dark:bg-slate-900/80 backdrop-blur-md border-slate-200 dark:border-slate-800 shadow-sm flex items-center justify-between px-8 z-40">
            <div class="flex items-center gap-4 flex-1">
                <div class="relative w-full max-w-md focus-within:ring-2 focus-within:ring-indigo-500/20 rounded-lg transition-all">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">search</span>
                    <input class="w-full pl-10 pr-4 py-2 bg-slate-100 dark:bg-slate-800 border-none rounded-lg text-sm focus:ring-0" placeholder="Search analytics, orders, or users..." type="text"/>
                </div>
            </div>
            
            <div class="flex items-center gap-6">
                <div class="h-8 w-px bg-slate-200 dark:bg-slate-700"></div>
                <div class="flex items-center gap-3">
                    <div class="text-right">
                        <p class="text-sm font-semibold text-slate-900 dark:text-white leading-none">{{ Auth::user()->name }}</p>
                        <p class="text-[10px] font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-tighter">Admin</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content Canvas -->
        <main class="mt-16 p-8 min-h-[calc(100vh-64px)]">
            <div class="max-w-[1400px] mx-auto">
                <div id="toast-container" class="fixed top-20 right-4 z-50 flex flex-col gap-2"></div>
                
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Global Toast Notification System
        function showToast(message, type = 'success') {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            
            // Colors based on type
            let bgClass = type === 'success' ? 'bg-emerald-50' : (type === 'error' ? 'bg-rose-50' : 'bg-blue-50');
            let borderClass = type === 'success' ? 'border-emerald-200' : (type === 'error' ? 'border-rose-200' : 'border-blue-200');
            let textClass = type === 'success' ? 'text-emerald-800' : (type === 'error' ? 'text-rose-800' : 'text-blue-800');
            let iconClass = type === 'success' ? 'text-emerald-500' : (type === 'error' ? 'text-rose-500' : 'text-blue-500');
            let iconName = type === 'success' ? 'check_circle' : (type === 'error' ? 'error' : 'info');
            
            toast.className = `animate-slideIn flex items-center gap-3 px-4 py-3 rounded-xl border ${bgClass} ${borderClass} shadow-lg`;
            toast.innerHTML = `
                <span class="material-symbols-outlined ${iconClass}">${iconName}</span>
                <p class="text-sm font-medium ${textClass}">${message}</p>
                <button onclick="this.parentElement.remove()" class="ml-2 text-slate-400 hover:text-slate-600">
                    <span class="material-symbols-outlined text-sm">close</span>
                </button>
            `;
            
            container.appendChild(toast);
            
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateX(100%)';
                toast.style.transition = 'all 0.3s ease-out';
                setTimeout(() => toast.remove(), 300);
            }, 4000);
        }

        // Handle Laravel Session Flashes
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success')) showToast("{{ session('success') }}", 'success'); @endif
            @if(session('error')) showToast("{{ session('error') }}", 'error'); @endif
            @if(session('warning')) showToast("{{ session('warning') }}", 'warning'); @endif
            @if(session('info')) showToast("{{ session('info') }}", 'info'); @endif
        });
    </script>
    @stack('scripts')
</body>
</html>