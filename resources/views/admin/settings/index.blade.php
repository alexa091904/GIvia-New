@extends('admin.layouts.admin')

@section('page-title', 'Platform Settings')

@section('content')
<!-- Page Header -->
<div class="mb-8 flex justify-between items-end">
    <div>
        <h2 class="font-black text-3xl text-slate-900 tracking-tight mb-1">Platform Settings</h2>
        <p class="text-sm text-slate-500">Manage your store configurations and preferences</p>
    </div>
    <div class="flex gap-3">
        <button class="px-4 py-2 bg-white border border-slate-200 text-slate-700 font-semibold text-sm rounded-lg hover:bg-slate-50 transition-all shadow-sm">
            Export Config
        </button>
    </div>
</div>

<!-- Content Grid -->
<div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
    <!-- Navigation Tabs (Sidebar Layout for settings) -->
    <div class="lg:col-span-1 space-y-2" id="settingsSidebar">
        <button data-target="general" class="tab-btn w-full flex items-center justify-between px-4 py-3 rounded-xl bg-indigo-50 text-indigo-700 font-semibold text-sm border border-indigo-100 shadow-sm transition-all">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-indigo-600">settings_suggest</span>
                <span>General</span>
            </div>
            <span class="material-symbols-outlined text-indigo-300">chevron_right</span>
        </button>
        <button data-target="payment" class="tab-btn w-full flex items-center justify-between px-4 py-3 rounded-xl hover:bg-slate-50 text-slate-600 font-semibold text-sm transition-all border border-transparent">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-slate-400">payments</span>
                <span>Payment Gateways</span>
            </div>
        </button>
        <button data-target="shipping" class="tab-btn w-full flex items-center justify-between px-4 py-3 rounded-xl hover:bg-slate-50 text-slate-600 font-semibold text-sm transition-all border border-transparent">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-slate-400">local_shipping</span>
                <span>Shipping Config</span>
            </div>
        </button>
        <button data-target="system" class="tab-btn w-full flex items-center justify-between px-4 py-3 rounded-xl hover:bg-slate-50 text-slate-600 font-semibold text-sm transition-all border border-transparent">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-slate-400">build</span>
                <span>System</span>
            </div>
        </button>
    </div>

    <!-- Main Configuration Panel -->
    <div class="lg:col-span-3">
        <!-- GENERAL TAB -->
        <div id="general" class="tab-content block bg-white rounded-2xl shadow-[0px_4px_20px_rgba(0,0,0,0.05)] border border-slate-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <div>
                    <h3 class="font-semibold text-lg text-slate-900">General Settings</h3>
                    <p class="text-sm text-slate-500">Global metadata and regional preferences for your instance.</p>
                </div>
                <div class="h-10 w-10 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600">
                    <span class="material-symbols-outlined">tune</span>
                </div>
            </div>
            <div class="p-6">
                <form method="POST" action="{{ route('admin.settings.general') }}" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-slate-700 uppercase">Store Name</label>
                            <input name="site_name" value="{{ $settings['site_name'] ?? 'GIVIA Store' }}" required class="w-full px-4 py-3 rounded-lg border border-slate-200 bg-white text-slate-900 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all" type="text" />
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-slate-700 uppercase">Contact Email</label>
                            <input name="site_email" value="{{ $settings['site_email'] ?? 'admin@givia.com' }}" required class="w-full px-4 py-3 rounded-lg border border-slate-200 bg-white text-slate-900 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all" type="email" />
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-slate-700 uppercase">Contact Phone</label>
                            <input name="site_phone" value="{{ $settings['site_phone'] ?? '' }}" class="w-full px-4 py-3 rounded-lg border border-slate-200 bg-white text-slate-900 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all" type="text" />
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-slate-700 uppercase">Currency (3-letter)</label>
                            <input name="currency" value="{{ $settings['currency'] ?? 'USD' }}" maxlength="3" required class="w-full px-4 py-3 rounded-lg border border-slate-200 bg-white text-slate-900 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all" type="text" />
                        </div>
                        <div class="space-y-2 md:col-span-2">
                            <label class="text-xs font-bold text-slate-700 uppercase">Store Address</label>
                            <textarea name="site_address" rows="3" class="w-full px-4 py-3 rounded-lg border border-slate-200 bg-white text-slate-900 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">{{ $settings['site_address'] ?? '' }}</textarea>
                        </div>
                    </div>
                    <div class="pt-6 flex items-center justify-end gap-3 border-t border-slate-100">
                        <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white font-semibold text-sm rounded-lg shadow-lg shadow-indigo-200 hover:bg-indigo-700 active:scale-95 transition-all">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- PAYMENT TAB -->
        <div id="payment" class="tab-content hidden bg-white rounded-2xl shadow-[0px_4px_20px_rgba(0,0,0,0.05)] border border-slate-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <div>
                    <h3 class="font-semibold text-lg text-slate-900">Payment Gateways</h3>
                    <p class="text-sm text-slate-500">Configure Stripe, PayPal, and offline payment methods.</p>
                </div>
            </div>
            <div class="p-6">
                <form method="POST" action="{{ route('admin.settings.payment') }}" class="space-y-8">
                    @csrf
                    <div>
                        <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Stripe Configuration</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-slate-700">Publishable Key</label>
                                <input name="stripe_key" value="{{ $settings['stripe_key'] ?? '' }}" class="w-full px-4 py-3 rounded-lg border border-slate-200 bg-white text-sm focus:ring-2 focus:ring-indigo-500/20 outline-none transition-all" type="text" />
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-slate-700">Secret Key</label>
                                <input name="stripe_secret" value="{{ $settings['stripe_secret'] ?? '' }}" class="w-full px-4 py-3 rounded-lg border border-slate-200 bg-white text-sm focus:ring-2 focus:ring-indigo-500/20 outline-none transition-all" type="password" />
                            </div>
                        </div>
                    </div>
                    
                    <div class="border-t border-slate-100 pt-8">
                        <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">PayPal Configuration</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-slate-700">Client ID</label>
                                <input name="paypal_client_id" value="{{ $settings['paypal_client_id'] ?? '' }}" class="w-full px-4 py-3 rounded-lg border border-slate-200 bg-white text-sm focus:ring-2 focus:ring-indigo-500/20 outline-none transition-all" type="text" />
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-slate-700">Secret</label>
                                <input name="paypal_secret" value="{{ $settings['paypal_secret'] ?? '' }}" class="w-full px-4 py-3 rounded-lg border border-slate-200 bg-white text-sm focus:ring-2 focus:ring-indigo-500/20 outline-none transition-all" type="password" />
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-slate-700">Environment Mode</label>
                                <select name="paypal_mode" class="w-full px-4 py-3 rounded-lg border border-slate-200 bg-white text-sm focus:ring-2 focus:ring-indigo-500/20 outline-none transition-all">
                                    <option value="sandbox" {{ ($settings['paypal_mode'] ?? '') == 'sandbox' ? 'selected' : '' }}>Sandbox (Test)</option>
                                    <option value="live" {{ ($settings['paypal_mode'] ?? '') == 'live' ? 'selected' : '' }}>Live (Production)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-slate-100 pt-8">
                        <div class="flex items-center justify-between p-4 rounded-xl bg-slate-50 border border-slate-100">
                            <div>
                                <p class="font-semibold text-slate-900">Cash on Delivery (COD)</p>
                                <p class="text-sm text-slate-500">Allow customers to pay upon receiving their orders.</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="hidden" name="cod_enabled" value="0">
                                <input type="checkbox" name="cod_enabled" value="1" {{ ($settings['cod_enabled'] ?? '1') == '1' ? 'checked' : '' }} class="sr-only peer">
                                <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                            </label>
                        </div>
                    </div>

                    <div class="pt-6 flex items-center justify-end gap-3 border-t border-slate-100">
                        <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white font-semibold text-sm rounded-lg shadow-lg shadow-indigo-200 hover:bg-indigo-700 active:scale-95 transition-all">Save Payments</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- SHIPPING TAB -->
        <div id="shipping" class="tab-content hidden bg-white rounded-2xl shadow-[0px_4px_20px_rgba(0,0,0,0.05)] border border-slate-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <div>
                    <h3 class="font-semibold text-lg text-slate-900">Shipping Config</h3>
                    <p class="text-sm text-slate-500">Manage delivery costs and thresholds.</p>
                </div>
            </div>
            <div class="p-6">
                <form method="POST" action="{{ route('admin.settings.shipping') }}" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-slate-700 uppercase">Free Shipping Threshold</label>
                            <input name="free_shipping_threshold" type="number" step="0.01" value="{{ $settings['free_shipping_threshold'] ?? 50 }}" class="w-full px-4 py-3 rounded-lg border border-slate-200 bg-white text-sm focus:ring-2 focus:ring-indigo-500/20 outline-none transition-all" />
                            <p class="text-[11px] text-slate-500">Orders above this amount get free shipping</p>
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-slate-700 uppercase">Standard Shipping Cost</label>
                            <input name="standard_shipping_cost" type="number" step="0.01" value="{{ $settings['standard_shipping_cost'] ?? 5.99 }}" class="w-full px-4 py-3 rounded-lg border border-slate-200 bg-white text-sm focus:ring-2 focus:ring-indigo-500/20 outline-none transition-all" />
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-slate-700 uppercase">Express Shipping Cost</label>
                            <input name="express_shipping_cost" type="number" step="0.01" value="{{ $settings['express_shipping_cost'] ?? 12.99 }}" class="w-full px-4 py-3 rounded-lg border border-slate-200 bg-white text-sm focus:ring-2 focus:ring-indigo-500/20 outline-none transition-all" />
                        </div>
                    </div>
                    <div class="pt-6 flex items-center justify-end gap-3 border-t border-slate-100">
                        <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white font-semibold text-sm rounded-lg shadow-lg shadow-indigo-200 hover:bg-indigo-700 active:scale-95 transition-all">Save Shipping</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- SYSTEM TAB -->
        <div id="system" class="tab-content hidden bg-white rounded-2xl shadow-[0px_4px_20px_rgba(0,0,0,0.05)] border border-slate-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <div>
                    <h3 class="font-semibold text-lg text-slate-900">System Maintenance</h3>
                    <p class="text-sm text-slate-500">View environment details and clear cache.</p>
                </div>
                <div class="h-10 w-10 rounded-full bg-amber-50 flex items-center justify-center text-amber-600">
                    <span class="material-symbols-outlined">warning</span>
                </div>
            </div>
            <div class="p-6">
                <div class="bg-slate-50 rounded-xl p-4 border border-slate-200 mb-6 font-mono text-sm text-slate-700">
                    <strong>System Information:</strong><br><br>
                    Laravel Version: <span class="text-indigo-600">{{ app()->version() }}</span><br>
                    PHP Version: <span class="text-indigo-600">{{ phpversion() }}</span><br>
                    Environment: <span class="text-indigo-600">{{ app()->environment() }}</span>
                </div>
                
                <form method="POST" action="{{ route('admin.settings.cache') }}" class="border-t border-slate-100 pt-6">
                    @csrf
                    <p class="text-sm text-slate-600 mb-4">If you are experiencing issues with outdated data or styling, clearing the cache might help.</p>
                    <button type="submit" class="px-6 py-2.5 bg-rose-600 text-white font-semibold text-sm rounded-lg shadow-lg shadow-rose-200 hover:bg-rose-700 active:scale-95 transition-all" onclick="return confirm('Clear all application cache?')">
                        <span class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-[18px]">delete_sweep</span>
                            Clear Application Cache
                        </span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const btns = document.querySelectorAll('.tab-btn');
        const contents = document.querySelectorAll('.tab-content');
        
        btns.forEach(btn => {
            btn.addEventListener('click', () => {
                const targetId = btn.getAttribute('data-target');
                
                // Reset all contents
                contents.forEach(c => c.classList.add('hidden'));
                // Reset all buttons
                btns.forEach(b => {
                    b.classList.remove('bg-indigo-50', 'text-indigo-700', 'border-indigo-100', 'shadow-sm');
                    b.classList.add('hover:bg-slate-50', 'text-slate-600', 'border-transparent');
                    b.querySelector('span.material-symbols-outlined:first-child').classList.replace('text-indigo-600', 'text-slate-400');
                    if(b.querySelector('span:last-child').classList.contains('text-indigo-300')) {
                        b.querySelector('span:last-child').remove();
                    }
                });
                
                // Show target content
                document.getElementById(targetId).classList.remove('hidden');
                
                // Active button styles
                btn.classList.add('bg-indigo-50', 'text-indigo-700', 'border-indigo-100', 'shadow-sm');
                btn.classList.remove('hover:bg-slate-50', 'text-slate-600', 'border-transparent');
                btn.querySelector('span.material-symbols-outlined:first-child').classList.replace('text-slate-400', 'text-indigo-600');
                
                if(!btn.querySelector('span:last-child').classList.contains('text-indigo-300')) {
                    btn.insertAdjacentHTML('beforeend', '<span class="material-symbols-outlined text-indigo-300">chevron_right</span>');
                }
            });
        });
    });
</script>
@endsection