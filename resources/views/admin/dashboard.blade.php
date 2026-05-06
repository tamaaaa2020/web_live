@extends('admin.layout')

@section('title', 'Dashboard Overview')
@section('subtitle', 'Welcome back, here is what is happening with your links today.')

@section('content')
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <!-- Total Clicks -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path></svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-500">Total Clicks</p>
                    <h3 class="text-2xl font-bold text-slate-900">{{ number_format($totalClicks) }}</h3>
                </div>
            </div>
            <div class="flex items-center text-xs font-semibold text-emerald-500 bg-emerald-50 w-fit px-2 py-1 rounded-lg">
                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd"></path></svg>
                Lifetime stats
            </div>
        </div>

        <!-- Placeholder for more stats -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-500">Active Links</p>
                    <h3 class="text-2xl font-bold text-slate-900">{{ number_format($topLinks->count()) }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Daily Activity -->
        <div class="lg:col-span-2 bg-white p-8 rounded-3xl border border-slate-100 shadow-sm">
            <div class="flex items-center justify-between mb-8">
                <h3 class="text-xl font-bold text-slate-900">Daily Activity</h3>
                <span class="text-sm font-medium text-slate-400">Last 14 days</span>
            </div>

            @php
                $max = 0;
                foreach ($daily as $row) { $max = max($max, (int) $row['clicks']); }
                $max = max($max, 1);
            @endphp

            <div class="space-y-4">
                @foreach ($daily as $row)
                    @php $pct = (int) round(((int) $row['clicks'] / $max) * 100); @endphp
                    <div class="group">
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="text-xs font-semibold text-slate-500 group-hover:text-slate-900 transition-colors">{{ $row['day'] }}</span>
                            <span class="text-xs font-bold text-slate-900">{{ number_format($row['clicks']) }}</span>
                        </div>
                        <div class="w-full bg-slate-50 rounded-full h-2">
                            <div class="bg-blue-500 h-2 rounded-full transition-all duration-500" style="width: {{ $pct }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Top Performing Links -->
        <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm">
            <h3 class="text-xl font-bold text-slate-900 mb-6">Top Links</h3>
            <div class="space-y-6">
                @forelse ($topLinks as $row)
                    <div class="flex items-center justify-between group">
                        <div class="flex-1 min-w-0 mr-4">
                            <p class="text-sm font-bold text-slate-900 truncate group-hover:text-blue-600 transition-colors">{{ $row->slug }}</p>
                            <p class="text-xs text-slate-400 truncate">{{ $row->original_url }}</p>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-50 text-blue-700">
                                {{ number_format($row->clicks) }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-10">
                        <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <p class="text-sm font-medium text-slate-400">No data available yet</p>
                    </div>
                @endforelse
            </div>
            
            <a href="{{ route('admin.links.index') }}" class="mt-8 block w-full py-3 text-center text-sm font-bold text-slate-600 bg-slate-50 rounded-xl hover:bg-slate-100 transition-colors">
                View All Links
            </a>
        </div>
    </div>
@endsection