@extends('admin.layout')

@section('title', 'Analytics Detail')
@section('subtitle', 'Drill down into every click to understand your traffic sources.')

@section('content')
    <div class="mb-8 bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div>
                <label for="slug" class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 px-1">Filter Slug</label>
                <input type="text" id="slug" name="slug" value="{{ $slug }}" 
                    class="block w-full rounded-xl border-slate-100 bg-slate-50/50 px-4 py-3 text-slate-900 text-sm font-medium focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all placeholder:text-slate-400" placeholder="e.g. promo.mp4">
            </div>
            <div>
                <label for="domain" class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 px-1">Domain Source</label>
                <input type="text" id="domain" name="domain" value="{{ $domain }}" 
                    class="block w-full rounded-xl border-slate-100 bg-slate-50/50 px-4 py-3 text-slate-900 text-sm font-medium focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all placeholder:text-slate-400" placeholder="e.g. example.com">
            </div>
            <div>
                <label for="country" class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 px-1">Country Code</label>
                <input type="text" id="country" name="country" value="{{ $country }}" 
                    class="block w-full rounded-xl border-slate-100 bg-slate-50/50 px-4 py-3 text-slate-900 text-sm font-medium focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all placeholder:text-slate-400" placeholder="e.g. ID, US">
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 bg-slate-900 text-white py-3 rounded-xl text-sm font-bold hover:bg-slate-800 transition-all">
                    Apply Filter
                </button>
                <a href="{{ route('admin.analytics.index') }}" class="px-4 py-3 bg-slate-100 text-slate-600 rounded-xl text-sm font-bold hover:bg-slate-200 transition-all">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Time</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Slug</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Source Domain</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Location</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">IP Address</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse ($clicks as $row)
                        <tr class="hover:bg-slate-50/30 transition-colors">
                            <td class="px-6 py-5 whitespace-nowrap">
                                <span class="text-xs font-bold text-slate-900">{{ $row->created_at->format('M d, H:i:s') }}</span>
                            </td>
                            <td class="px-6 py-5">
                                <span class="text-sm font-bold text-blue-600">{{ $row->slug }}</span>
                            </td>
                            <td class="px-6 py-5">
                                <span class="text-sm font-medium text-slate-600">{{ $row->domain_source }}</span>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-2">
                                    <span class="inline-block w-2 h-2 rounded-full bg-blue-400"></span>
                                    <span class="text-sm font-bold text-slate-700">{{ $row->country ?: 'Unknown' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <span class="text-xs font-mono text-slate-400 bg-slate-50 px-2 py-1 rounded border border-slate-100">{{ $row->ip }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-20 text-center">
                                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m0 0a2 2 0 002 2h2a2 2 0 002-2v-6a2 2 0 00-2-2h-2a2 2 0 00-2 2v6z"></path></svg>
                                </div>
                                <h4 class="text-lg font-bold text-slate-900 mb-1">No traffic logs</h4>
                                <p class="text-sm text-slate-400">Wait for users to click your links to see detailed analytics.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($clicks->hasPages())
            <div class="px-6 py-6 bg-slate-50/50 border-t border-slate-100">
                {{ $clicks->links() }}
            </div>
        @endif
    </div>
@endsection