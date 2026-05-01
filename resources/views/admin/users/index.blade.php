@extends('admin.layouts.admin')

@section('page-title', 'Manage Users')

@section('content')
<!-- Page Header -->
<div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
    <div>
        <h1 class="font-black text-3xl text-slate-900 tracking-tight">Users</h1>
        <p class="text-sm text-slate-500 mt-1">Manage and monitor your platform's user base.</p>
    </div>
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.users.export', request()->query()) }}" class="flex items-center gap-2 px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 active:scale-95 transition-all">
            <span class="material-symbols-outlined text-[20px]">file_download</span>
            Export Data
        </a>
    </div>
</div>

<!-- Filter Bar -->
<form method="GET" action="{{ route('admin.users.index') }}" class="bg-white/70 backdrop-blur-xl border border-slate-200/50 p-4 rounded-2xl flex flex-col md:flex-row items-center gap-4 mb-8 shadow-sm">
    <div class="relative flex-1 w-full">
        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">search</span>
        <input name="search" value="{{ request('search') }}" class="w-full pl-11 pr-4 py-3 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all" placeholder="Search by name or email..." type="text"/>
    </div>
    <div class="flex items-center gap-3 w-full md:w-auto">
        <div class="relative w-full md:w-48">
            <select name="role" onchange="this.form.submit()" class="w-full appearance-none bg-white border border-slate-200 px-4 py-3 rounded-xl text-sm font-medium text-slate-700 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all cursor-pointer">
                <option value="All Roles" {{ request('role') == 'All Roles' ? 'selected' : '' }}>All Roles</option>
                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
            </select>
            <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">expand_more</span>
        </div>
        <button type="submit" class="px-4 py-3 bg-indigo-50 border border-indigo-100 rounded-xl text-indigo-600 hover:bg-indigo-600 hover:text-white transition-colors font-semibold text-sm">
            Search
        </button>
        @if(request()->has('search') || request()->has('role'))
        <a href="{{ route('admin.users.index') }}" class="p-3 bg-white border border-slate-200 rounded-xl text-slate-500 hover:text-rose-600 hover:border-rose-100 transition-colors" title="Clear Filters">
            <span class="material-symbols-outlined">close</span>
        </a>
        @endif
    </div>
</form>

<!-- Data Table Section -->
<div class="bg-white rounded-2xl shadow-[0px_4px_20px_rgba(0,0,0,0.05)] border border-slate-100 overflow-hidden mb-8">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/50 border-b border-slate-100">
                    <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">User</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Role</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Orders</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Registered Date</th>
                    <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-wider text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($users as $user)
                <tr class="hover:bg-slate-50/50 transition-colors group">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="relative w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center font-bold text-slate-500 border border-slate-200">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="font-semibold text-sm text-slate-900 leading-tight">{{ $user->name }}</p>
                                <p class="text-xs text-slate-500 font-medium">ID: {{ $user->id }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 font-medium text-sm text-slate-600">{{ $user->email }}</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold tracking-wide uppercase border {{ $user->role == 'admin' ? 'bg-indigo-50 text-indigo-700 border-indigo-100' : 'bg-slate-50 text-slate-600 border-slate-200' }}">
                            {{ ucfirst($user->role ?? 'user') }}
                        </span>
                    </td>
                    <td class="px-6 py-4 font-bold text-sm text-slate-900">
                        {{ $user->orders->count() }}
                    </td>
                    <td class="px-6 py-4 font-medium text-sm text-slate-600">{{ $user->created_at->format('M d, Y') }}</td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <form action="{{ route('admin.users.role', $user->id) }}" method="POST" class="m-0">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="role" value="{{ $user->role === 'admin' ? 'user' : 'admin' }}">
                                <button type="submit" class="p-1.5 text-slate-400 hover:text-indigo-600 transition-colors" title="Toggle Role">
                                    <span class="material-symbols-outlined text-[20px]">{{ $user->role === 'admin' ? 'person_remove' : 'admin_panel_settings' }}</span>
                                </button>
                            </form>
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="m-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 transition-colors" title="Delete User" onclick="return confirm('Delete this user?')">
                                    <span class="material-symbols-outlined text-[20px]">delete</span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-slate-500">No users found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if(method_exists($users, 'links'))
    <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100">
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection