@extends('layouts.app')

@section('title', 'GIVIA')

@section('content')
<!-- Hero Section -->
<section class="relative pt-32 pb-20 md:pt-48 md:pb-32 overflow-hidden">
    <!-- Background Decor -->
    <div class="absolute top-0 inset-x-0 h-[600px] bg-gradient-to-b from-primary-50/50 to-transparent -z-10"></div>
    <div class="absolute -top-40 -right-40 w-96 h-96 bg-primary-200/40 rounded-full blur-3xl -z-10"></div>
    <div class="absolute top-20 -left-40 w-96 h-96 bg-purple-200/40 rounded-full blur-3xl -z-10"></div>

    <div class="max-w-[1280px] mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <!-- Text Content -->
            <div class="max-w-xl">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white shadow-sm border border-slate-100 mb-6 animate-fadeIn">
                    <span class="w-2 h-2 rounded-full bg-primary-500 animate-pulse"></span>
                    <span class="text-xs font-semibold uppercase tracking-widest text-slate-600">New Collection 2026</span>
                </div>
                <h1 class="text-5xl md:text-6xl font-bold tracking-tight text-slate-900 leading-[1.1] mb-6 animate-slideUp">
                    Create moments <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-600 to-purple-500">through gifts.</span>
                </h1>
                <p class="text-lg text-slate-500 mb-8 leading-relaxed">
                    Discover a curated collection of gifts and personalized items designed to make every moment meaningful and every experience more convenient.
                </p>
                <div class="flex flex-wrap items-center gap-4">
                    <a href="/shop" class="px-8 py-4 bg-slate-900 hover:bg-primary-600 text-white rounded-xl font-medium transition-all shadow-lg shadow-slate-900/20 hover:shadow-primary-600/30 flex items-center gap-2">
                        Shop Collection <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </a>
                    <a href="#featured" class="px-8 py-4 bg-white text-slate-700 hover:text-primary-600 rounded-xl font-medium transition-all shadow-sm border border-slate-200 hover:border-primary-200 flex items-center gap-2">
                        View Featured
                    </a>
                </div>
                
                <div class="mt-12 flex items-center gap-8 border-t border-slate-200/60 pt-8">
                    <div>
                        <p class="text-3xl font-bold text-slate-900">10k+</p>
                        <p class="text-sm text-slate-500">Happy Customers</p>
                    </div>
                    <div class="w-px h-12 bg-slate-200"></div>
                    <div>
                        <p class="text-3xl font-bold text-slate-900">4.9/5</p>
                        <p class="text-sm text-slate-500 flex items-center gap-1">
                            <span class="material-symbols-outlined text-amber-400 text-[16px]" style="font-variation-settings: 'FILL' 1;">star</span>
                            Rating
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Hero Image -->
            <div class="relative">
                <div class="absolute inset-0 bg-gradient-to-tr from-primary-500 to-purple-400 rounded-3xl transform rotate-3 scale-105 opacity-20 blur-xl"></div>
                <div class="relative rounded-3xl overflow-hidden shadow-2xl border border-white/50 aspect-[4/5] md:aspect-square bg-white">
                    <img src="https://www.litcandleco.ph/cdn/shop/files/Lit_Custom_Candles.png?v=1725116210&width=1500" alt="Premium Products" class="w-full h-full object-cover">
                    <!-- Glass floating badge -->
                    <div class="absolute bottom-6 -left-6 glass-card px-6 py-4 rounded-2xl flex items-center gap-4 animate-bounce" style="animation-duration: 3s;">
                        <div class="w-12 h-12 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600">
                            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">verified</span>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-900">Premium Quality</p>
                            <p class="text-xs text-slate-500">100% Authenticity Guarantee</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Strip -->
<section class="border-y border-slate-100 bg-white">
    <div class="max-w-[1280px] mx-auto px-6 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 divide-y md:divide-y-0 md:divide-x divide-slate-100">

        </div>
    </div>
</section>

<!-- Featured Products (Dynamic) -->
<section id="featured" class="py-24 bg-slate-50">
    <div class="max-w-[1280px] mx-auto px-6">
        <div class="flex items-end justify-between mb-12">
            <div>
                <h2 class="text-3xl font-bold text-slate-900 mb-2">Featured Products</h2>
                <p class="text-slate-500">Handpicked items for exceptional quality.</p>
            </div>
            <a href="/shop" class="text-primary-600 font-medium hover:text-primary-700 flex items-center gap-1 transition-colors">
                View All <span class="material-symbols-outlined text-sm">arrow_forward</span>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @if(isset($featuredProducts) && $featuredProducts->count() > 0)
                @foreach($featuredProducts as $product)
                    <a href="{{ route('products.show', $product->id) }}" class="group bg-white rounded-2xl p-4 transition-all hover:shadow-glass border border-slate-100 flex flex-col h-full">
                        <div class="relative aspect-square rounded-xl overflow-hidden mb-4 bg-slate-50">
                            @if($product->image_url || $product->image)
                                <img src="{{ $product->image_url ?? asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-300">
                                    <span class="material-symbols-outlined text-6xl">image</span>
                                </div>
                            @endif
                            
                            @if($product->stock <= 5 && $product->stock > 0)
                                <div class="absolute top-3 left-3 bg-rose-500 text-white text-[10px] font-bold uppercase tracking-wider px-2 py-1 rounded-full">
                                    Low Stock
                                </div>
                            @endif
                        </div>
                        
                        <div class="flex-1 flex flex-col justify-between">
                            <div>
                                <h3 class="font-semibold text-slate-900 mb-1 group-hover:text-primary-600 transition-colors">{{ $product->name }}</h3>
                                <p class="text-sm text-slate-500 line-clamp-2 mb-4">{{ Str::limit($product->description, 80) }}</p>
                            </div>
                            <div class="flex items-center justify-between mt-auto">
                                <span class="text-lg font-bold text-slate-900">₱{{ number_format($product->price, 2) }}</span>
                                <button class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center text-slate-600 group-hover:bg-primary-600 group-hover:text-white transition-colors" onclick="event.preventDefault(); window.location='{{ route('products.show', $product->id) }}';">
                                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                                </button>
                            </div>
                        </div>
                    </a>
                @endforeach
            @else
                <!-- Skeletons if no products found -->
                @for($i = 0; $i < 4; $i++)
                    <div class="bg-white rounded-2xl p-4 border border-slate-100">
                        <div class="w-full aspect-square bg-slate-100 rounded-xl mb-4 animate-pulse"></div>
                        <div class="w-3/4 h-5 bg-slate-100 rounded mb-2 animate-pulse"></div>
                        <div class="w-1/2 h-4 bg-slate-100 rounded mb-4 animate-pulse"></div>
                        <div class="flex justify-between items-center mt-4">
                            <div class="w-16 h-6 bg-slate-100 rounded animate-pulse"></div>
                            <div class="w-8 h-8 rounded-full bg-slate-100 animate-pulse"></div>
                        </div>
                    </div>
                @endfor
            @endif
        </div>
    </div>
</section>


@endsection