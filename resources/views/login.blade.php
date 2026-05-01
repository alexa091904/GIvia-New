<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login | Givia</title>
    
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL,GRAD,opsz@300,0,0,24&display=swap" rel="stylesheet" />

    <!-- Fix: Patch MutationObserver before Tailwind CDN loads to prevent null-node crash -->
    <script>
        (function() {
            var _MO = window.MutationObserver;
            window.MutationObserver = function(cb) {
                var obs = new _MO(cb);
                var _observe = obs.observe.bind(obs);
                obs.observe = function(target, opts) {
                    if (!target || !(target instanceof Node)) return;
                    return _observe(target, opts);
                };
                return obs;
            };
            window.MutationObserver.prototype = _MO.prototype;
        })();
    </script>
    <!-- Tailwind CSS: config MUST be defined before CDN loads -->
    <script>
        tailwind = window.tailwind || {};
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        primary: {
                            50: '#eef2ff', 100: '#e0e7ff', 200: '#c7d2fe', 300: '#a5b4fc', 400: '#818cf8',
                            500: '#6366f1', 600: '#4f46e5', 700: '#4338ca', 800: '#3730a3', 900: '#312e81',
                        },
                        slate: {
                            50: '#f8fafc', 100: '#f1f5f9', 200: '#e2e8f0', 300: '#cbd5e1', 400: '#94a3b8',
                            500: '#64748b', 600: '#475569', 700: '#334155', 800: '#1e293b', 900: '#0f172a',
                        }
                    },
                    boxShadow: {
                        'glass': '0 20px 40px rgba(30, 41, 59, 0.05)',
                        'glow': '0 0 20px rgba(79, 70, 229, 0.2)',
                    }
                }
            }
        };
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white font-sans antialiased text-slate-800 flex flex-col lg:flex-row min-h-screen relative overflow-hidden">

    <!-- Left Side: Form -->
    <div class="w-full lg:w-1/2 p-10 md:p-14 lg:px-24 xl:px-32 flex flex-col justify-center relative z-10">
        
        <!-- Background Decor (Moved inside left panel) -->
        <div class="absolute top-[-20%] right-[-10%] w-[800px] h-[800px] bg-primary-100 rounded-full blur-[100px] -z-10 opacity-40"></div>
        <div class="absolute bottom-[-20%] left-[-10%] w-[600px] h-[600px] bg-purple-100 rounded-full blur-[100px] -z-10 opacity-40"></div>
            
            <a href="/" class="flex items-center gap-2 mb-12 w-max">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-primary-600 to-purple-500 flex items-center justify-center text-white">
                    <span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' 1;">auto_awesome</span>
                </div>
                <span class="text-xl font-bold tracking-tight text-slate-900">Givia</span>
            </a>

            <div>
                <h1 class="text-3xl font-bold text-slate-900 mb-2 tracking-tight">Welcome back</h1>
                <p class="text-slate-500 mb-8">Please enter your details to sign in.</p>

                @if ($errors->any())
                    <div class="bg-rose-50 border border-rose-100 text-rose-600 px-4 py-3 rounded-xl mb-6 flex items-start gap-3">
                        <span class="material-symbols-outlined text-[20px]">error</span>
                        <div class="text-sm">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf
                    
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition-all placeholder:text-slate-400"
                            placeholder="Enter your email">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">Password</label>
                        <input type="password" name="password" required
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition-all placeholder:text-slate-400"
                            placeholder="••••••••">
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <div class="relative flex items-center justify-center">
                                <input type="checkbox" name="remember" class="peer appearance-none w-4 h-4 border border-slate-300 rounded cursor-pointer checked:bg-primary-600 checked:border-primary-600 transition-colors">
                                <span class="material-symbols-outlined text-[14px] text-white absolute pointer-events-none opacity-0 peer-checked:opacity-100 transition-opacity">check</span>
                            </div>
                            <span class="text-sm text-slate-600 group-hover:text-slate-900 transition-colors">Remember me</span>
                        </label>
                        
                        <a href="#" class="text-sm font-medium text-primary-600 hover:text-primary-700 transition-colors">Forgot password?</a>
                    </div>

                    <button type="submit" class="w-full bg-slate-900 hover:bg-primary-600 text-white rounded-xl py-3.5 font-medium transition-all shadow-lg shadow-slate-900/10 hover:shadow-primary-600/20 mt-4">
                        Sign In
                    </button>
                    
                    <button type="button" class="w-full bg-white border border-slate-200 text-slate-700 hover:border-slate-300 hover:bg-slate-50 rounded-xl py-3.5 font-medium transition-all flex items-center justify-center gap-2 mt-4">
                        <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-5 h-5" alt="Google">
                        Sign in with Google
                    </button>
                </form>

                <p class="text-center text-sm text-slate-500 mt-8">
                    Don't have an account? <a href="{{ route('register') }}" class="font-semibold text-primary-600 hover:text-primary-700 transition-colors">Sign up for free</a>
                </p>
            </div>
        </div>

        <!-- Right Side: Image/Branding -->
        <div class="hidden lg:block w-1/2 relative bg-slate-900">
            <img src="{{ asset('images/login_bg.png') }}" alt="Interior" class="absolute inset-0 w-full h-full object-cover opacity-60">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/40 to-transparent"></div>
            
            <div class="absolute inset-x-0 bottom-0 p-12 lg:p-24 text-white">
                <div class="glass-card bg-white/10 backdrop-blur-md border-white/20 p-8 rounded-2xl">
                    <p class="text-lg font-medium leading-relaxed mb-6">
                        "Givia has completely transformed how I furnish my home. The quality and curation are unmatched in the modern eCommerce space."
                    </p>
                    <div class="flex items-center gap-4">
                        <img src="https://i.pravatar.cc/100?img=5" class="w-10 h-10 rounded-full border border-white/30" alt="Avatar">
                        <div>
                            <p class="text-sm font-semibold">Sarah Jenkins</p>
                            <p class="text-xs text-white/70">Interior Designer</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

</body>
</html>