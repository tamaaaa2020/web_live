<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Admin') - {{ config('app.name') }}</title>
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="bg-slate-50 text-slate-900">
        <div class="min-h-screen flex">
            <aside class="w-64 bg-white border-r border-slate-200 hidden md:flex md:flex-col">
                <div class="px-4 py-4 border-b border-slate-200">
                    <div class="text-sm font-semibold">{{ config('app.name') }}</div>
                    <div class="text-xs text-slate-500">Admin Dashboard</div>
                </div>
                <nav class="p-3 space-y-1">
                    <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-lg hover:bg-slate-100 {{ request()->routeIs('admin.dashboard') ? 'bg-slate-100 font-medium' : '' }}">Overview</a>
                    <a href="{{ route('admin.links.index') }}" class="block px-3 py-2 rounded-lg hover:bg-slate-100 {{ request()->routeIs('admin.links.*') ? 'bg-slate-100 font-medium' : '' }}">Link Manager</a>
                    <a href="{{ route('admin.domains.index') }}" class="block px-3 py-2 rounded-lg hover:bg-slate-100 {{ request()->routeIs('admin.domains.*') ? 'bg-slate-100 font-medium' : '' }}">Domain Manager</a>
                    <a href="{{ route('admin.analytics.index') }}" class="block px-3 py-2 rounded-lg hover:bg-slate-100 {{ request()->routeIs('admin.analytics.*') ? 'bg-slate-100 font-medium' : '' }}">Analytics</a>
                </nav>
            </aside>

            <div class="flex-1 flex flex-col">
                <header class="bg-white border-b border-slate-200 px-4 py-4 md:px-6">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <div class="text-lg font-semibold leading-6">@yield('title', 'Admin')</div>
                            <div class="text-xs text-slate-500">@yield('subtitle')</div>
                        </div>
                        <div class="text-xs text-slate-500 hidden sm:block">{{ request()->getHost() }}</div>
                    </div>
                </header>

                <main class="p-4 md:p-6 space-y-6">
                    @if ($errors->any())
                        <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg p-4 text-sm">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @yield('content')
                </main>
            </div>
        </div>
    </body>
</html>

