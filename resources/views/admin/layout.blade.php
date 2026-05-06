<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') - {{ config('app.name') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
        .sidebar-item-active { 
            background-color: #f8fafc;
            color: #0f172a;
            font-weight: 600;
            box-shadow: inset 4px 0 0 #3b82f6;
        }
    </style>
</head>
<body class="bg-[#fcfcfd] text-slate-900 antialiased">
    <!-- Mobile Toggle -->
    <button data-drawer-target="sidebar" data-drawer-toggle="sidebar" aria-controls="sidebar" type="button" class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-slate-500 rounded-lg sm:hidden hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-slate-200">
        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"><path d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path></svg>
    </button>

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0 border-r border-slate-100 bg-white" aria-label="Sidebar">
        <div class="h-full px-4 py-8 overflow-y-auto flex flex-col">
            <div class="mb-10 px-2 flex items-center gap-3">
                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold">L</div>
                <span class="text-xl font-extrabold tracking-tight text-slate-900">{{ config('app.name') }}</span>
            </div>
            
            <nav class="space-y-1 flex-1">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center p-3 text-slate-500 rounded-xl hover:bg-slate-50 hover:text-slate-900 transition-all group {{ request()->routeIs('admin.dashboard') ? 'sidebar-item-active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Overview
                </a>
                <a href="{{ route('admin.links.index') }}" class="flex items-center p-3 text-slate-500 rounded-xl hover:bg-slate-50 hover:text-slate-900 transition-all group {{ request()->routeIs('admin.links.*') ? 'sidebar-item-active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                    Links
                </a>
                <a href="{{ route('admin.domains.index') }}" class="flex items-center p-3 text-slate-500 rounded-xl hover:bg-slate-50 hover:text-slate-900 transition-all group {{ request()->routeIs('admin.domains.*') ? 'sidebar-item-active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                    Domains
                </a>
                <a href="{{ route('admin.analytics.index') }}" class="flex items-center p-3 text-slate-500 rounded-xl hover:bg-slate-50 hover:text-slate-900 transition-all group {{ request()->routeIs('admin.analytics.*') ? 'sidebar-item-active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m0 0a2 2 0 002 2h2a2 2 0 002-2v-6a2 2 0 00-2-2h-2a2 2 0 00-2 2v6z"></path></svg>
                    Analytics
                </a>
            </nav>

            <!-- User Info & Logout -->
            <div class="mt-auto pt-6 border-t border-slate-100">
                <div class="px-2 mb-4">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Administrator</p>
                    <p class="text-sm font-semibold text-slate-900 truncate">{{ auth()->user()->email ?? 'admin@example.com' }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center p-3 text-red-500 rounded-xl hover:bg-red-50 transition-all font-medium">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="sm:ml-64 min-h-screen">
        <div class="px-8 py-10 max-w-7xl mx-auto">
            <!-- Page Header -->
            <div class="mb-10">
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">@yield('title')</h1>
                @if(View::hasSection('subtitle'))
                    <p class="mt-2 text-slate-500 font-medium">@yield('subtitle')</p>
                @endif
            </div>

            @if (session('success'))
                <div class="mb-6 p-4 text-sm text-emerald-700 bg-emerald-50 rounded-2xl border border-emerald-100 flex items-center gap-3">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"></path></svg>
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    @stack('scripts')
</body>
</html>