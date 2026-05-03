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

                </form>

                <p class="text-center text-sm text-slate-500 mt-8">
                    Don't have an account? <a href="{{ route('register') }}" class="font-semibold text-primary-600 hover:text-primary-700 transition-colors">Sign up for free</a>
                </p>
            </div>
        </div>

        <!-- Right Side: Emotional & Warm Visual Container -->
        <div class="hidden lg:block w-1/2 relative bg-orange-50 overflow-hidden">
            
            <!-- Blurred Collage Background -->
            <div class="absolute inset-0 grid grid-cols-2 grid-rows-2 gap-1 scale-110 blur-[8px] opacity-70 filter">
                <img src="https://images.unsplash.com/photo-1549465220-1a8b9238cd48?q=80&w=800&auto=format&fit=crop" class="w-full h-full object-cover rounded-2xl animate-pulse" style="animation-duration: 8s;" alt="Gift">
                <img src="https://images.unsplash.com/photo-1530103862676-de8892bc952f?q=80&w=800&auto=format&fit=crop" class="w-full h-full object-cover rounded-2xl animate-pulse" style="animation-duration: 10s;" alt="Celebration">
                <img src="https://images.unsplash.com/photo-1512418490979-92798cec1380?q=80&w=800&auto=format&fit=crop" class="w-full h-full object-cover rounded-2xl animate-pulse" style="animation-duration: 9s;" alt="Warm gift">
                <img src="https://images.unsplash.com/photo-1527529482837-4698179dc6ce?q=80&w=800&auto=format&fit=crop" class="w-full h-full object-cover rounded-2xl animate-pulse" style="animation-duration: 11s;" alt="Party">
            </div>

            <!-- Soft warm lighting overlays -->
            <div class="absolute inset-0 bg-gradient-to-tr from-rose-500/40 via-orange-400/40 to-amber-300/40 mix-blend-multiply"></div>
            <div class="absolute inset-0 bg-black/20"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-black/20"></div>

            <!-- Subtle Heart & Ribbon Motifs -->
            <div class="absolute inset-0 pointer-events-none overflow-hidden">
                <style>
                    @keyframes float-icon {
                        0%, 100% { transform: translateY(0) rotate(var(--rot)); }
                        50% { transform: translateY(-20px) rotate(var(--rot)); }
                    }
                    .float-heart { animation: float-icon 5s ease-in-out infinite; --rot: 12deg; }
                    .float-ribbon { animation: float-icon 6s ease-in-out infinite 1s; --rot: -12deg; }
                    .float-star { animation: float-icon 7s ease-in-out infinite 2s; --rot: 45deg; }
                </style>
                <span class="material-symbols-outlined absolute top-[20%] right-[25%] text-rose-200/40 text-6xl float-heart">favorite</span>
                <span class="material-symbols-outlined absolute bottom-[25%] left-[20%] text-rose-200/30 text-8xl float-ribbon">redeem</span>
                <span class="material-symbols-outlined absolute top-[40%] left-[10%] text-amber-100/30 text-5xl float-star">star</span>
            </div>

            <!-- Central Content Container -->
            <div class="absolute inset-0 flex flex-col items-center justify-center p-12 z-10 text-center">
                
                <h1 class="text-7xl lg:text-8xl font-black text-white tracking-tighter drop-shadow-[0_4px_10px_rgba(0,0,0,0.5)] mb-4">
                    GIVIA
                </h1>
                
                <p class="text-2xl lg:text-3xl font-medium text-rose-50 tracking-wide drop-shadow-[0_2px_4px_rgba(0,0,0,0.5)] mt-2">
                    Make every moment special.
                </p>

            </div>
        </div>

</body>
</html>