@extends('layouts.app')

@section('title', 'About Us | GIVIA')

@section('content')
<!-- Hero Section -->
<div class="bg-slate-900 py-24 relative overflow-hidden mt-20">
    <div class="absolute inset-0 bg-gradient-to-r from-primary-900/50 to-purple-900/50"></div>
    <div class="absolute top-0 right-0 w-96 h-96 bg-primary-500/20 rounded-full blur-3xl"></div>
    <div class="max-w-[1280px] mx-auto px-6 relative z-10 text-center">
        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/20 mb-6">
            <span class="text-xs font-semibold uppercase tracking-widest text-white">Our Story</span>
        </div>
        <h1 class="text-5xl font-bold text-white mb-6">Redefining Everyday Luxury</h1>
        <p class="text-white/80 max-w-2xl mx-auto text-lg leading-relaxed">We believe that every gift should bring joy, meaning, and a personal touch, making every moment more special and memorable.</p>
    </div>
</div>

<!-- Content Sections -->
<div class="max-w-[1280px] mx-auto px-6 py-24">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center mb-24">
        <div>
            <h2 class="text-3xl font-bold text-slate-900 mb-6">The Givia Philosophy</h2>
            <p class="text-slate-500 mb-4 leading-relaxed">
                Founded in 2026, GIVIA started with a simple idea: making gift-giving more meaningful, accessible, and convenient for everyone.
            </p>
            <p class="text-slate-500 mb-8 leading-relaxed">
                Our mission is to provide a seamless online shopping experience where customers can find, customize, and send thoughtful gifts anytime and anywhere. We aim to help users express their emotions through personalized items while supporting small business growth through digital innovation.
            </p>
            
            <div class="grid grid-cols-2 gap-8 border-t border-slate-100 pt-8">
                <div>
                    <h4 class="text-4xl font-bold text-primary-600 mb-2">10k+</h4>
                    <p class="text-sm font-medium text-slate-900 uppercase tracking-wider">Happy Customers</p>
                </div>
                <div>
                    <h4 class="text-4xl font-bold text-primary-600 mb-2">50+</h4>
                    <p class="text-sm font-medium text-slate-900 uppercase tracking-wider">Artisan Partners</p>
                </div>
            </div>
        </div>
        <div class="relative">
            <div class="absolute inset-0 bg-gradient-to-tr from-primary-500 to-purple-400 rounded-3xl transform -rotate-3 scale-105 opacity-20 blur-xl"></div>
            <div class="relative rounded-3xl overflow-hidden shadow-2xl border border-slate-100 aspect-square">
                <img src="https://somethingturquoise.com/wp-content/uploads/2018/11/BestBlanks.jpg" alt="Our Craft" class="w-full h-full object-cover">
            </div>
        </div>
    </div>

    <!-- Core Values -->
    <div class="text-center mb-16">
        <h2 class="text-3xl font-bold text-slate-900 mb-4">Our Core Values</h2>
        <p class="text-slate-500 max-w-xl mx-auto">The principles that guide every product we select and every experience we create.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-slate-50 rounded-3xl p-10 border border-slate-100 text-center hover:shadow-glass hover:-translate-y-1 transition-all duration-300">
            <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center text-primary-500 shadow-sm mx-auto mb-6">
                <span class="material-symbols-outlined text-3xl">workspace_premium</span>
            </div>
            <h3 class="text-xl font-bold text-slate-900 mb-3">Uncompromising Quality</h3>
            <p class="text-sm text-slate-500 leading-relaxed">We never settle for "good enough". Every piece in our collection is rigorously tested for durability and excellence.</p>
        </div>
        
        <div class="bg-slate-50 rounded-3xl p-10 border border-slate-100 text-center hover:shadow-glass hover:-translate-y-1 transition-all duration-300">
            <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center text-primary-500 shadow-sm mx-auto mb-6">
                <span class="material-symbols-outlined text-3xl">eco</span>
            </div>
            <h3 class="text-xl font-bold text-slate-900 mb-3">Sustainable Design</h3>
            <p class="text-sm text-slate-500 leading-relaxed">Beauty shouldn't cost the earth. We prioritize materials and manufacturing processes that are environmentally responsible.</p>
        </div>

        <div class="bg-slate-50 rounded-3xl p-10 border border-slate-100 text-center hover:shadow-glass hover:-translate-y-1 transition-all duration-300">
            <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center text-primary-500 shadow-sm mx-auto mb-6">
                <span class="material-symbols-outlined text-3xl">support_agent</span>
            </div>
            <h3 class="text-xl font-bold text-slate-900 mb-3">Exceptional Service</h3>
            <p class="text-sm text-slate-500 leading-relaxed">Your experience matters as much as our products. We provide white-glove support from discovery to delivery.</p>
        </div>
    </div>
</div>
@endsection
