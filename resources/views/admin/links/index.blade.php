@extends('admin.layout')

@section('title', 'Link Manager')
@section('subtitle', 'Create, manage, and track your shortlinks across multiple domains.')

@section('content')
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <!-- Search & Filter -->
        <form method="GET" class="flex flex-1 items-center max-w-2xl gap-3">
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" name="q" value="{{ $search }}" placeholder="Search slug or destination..." 
                    class="block w-full pl-11 pr-4 py-3 bg-white border border-slate-100 rounded-2xl text-sm focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 shadow-sm transition-all">
            </div>
            <select name="status" class="bg-white border border-slate-100 text-slate-600 text-sm rounded-2xl px-4 py-3 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 shadow-sm transition-all">
                <option value="">All Status</option>
                <option value="active" @selected($status === 'active')>Active</option>
                <option value="inactive" @selected($status === 'inactive')>Inactive</option>
            </select>
            <button type="submit" class="bg-slate-900 text-white px-6 py-3 rounded-2xl text-sm font-bold hover:bg-slate-800 transition-colors shadow-sm">
                Filter
            </button>
        </form>

        <a href="{{ route('admin.links.create') }}" class="inline-flex items-center justify-center bg-blue-600 text-white px-6 py-3 rounded-2xl text-sm font-bold hover:bg-blue-700 transition-colors shadow-lg shadow-blue-500/20">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Create New Link
        </a>
    </div>

    <!-- Bulk Action Bar -->
    <div class="mb-6 bg-blue-50/50 border border-blue-100 rounded-2xl p-4 flex flex-col md:flex-row items-center gap-4">
        <span class="text-xs font-bold text-blue-700 uppercase tracking-widest">Bulk Actions</span>
        <form id="bulk-form" method="POST" action="{{ route('admin.links.bulkUpdateDestination') }}" class="flex flex-1 items-center gap-3 w-full">
            @csrf
            <input type="text" name="destination_url" placeholder="New destination URL for selected links..." 
                class="flex-1 px-4 py-2.5 bg-white border border-blue-200 rounded-xl text-sm focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500">
            <button type="submit" class="bg-blue-600 text-white px-5 py-2.5 rounded-xl text-xs font-bold hover:bg-blue-700 transition-colors">
                Update Selected
            </button>
        </form>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-6 py-4 w-10">
                            <input type="checkbox" data-select-all class="rounded-md border-slate-300 text-blue-600 focus:ring-blue-500/20 w-4 h-4 cursor-pointer">
                        </th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Short Link</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Destination</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest text-center">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse ($links as $link)
                        <tr class="hover:bg-slate-50/30 transition-colors">
                            <td class="px-6 py-5">
                                <input type="checkbox" name="link_ids[]" value="{{ $link->id }}" form="bulk-form" class="rounded-md border-slate-300 text-blue-600 focus:ring-blue-500/20 w-4 h-4 cursor-pointer">
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-slate-900 mb-0.5">{{ $link->slug }}</span>
                                    <a href="/{{ $link->slug }}" target="_blank" class="text-[10px] font-medium text-blue-500 hover:underline flex items-center">
                                        Open Link <svg class="w-2.5 h-2.5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                    </a>
                                </div>
                            </td>
                            <td class="px-6 py-5 max-w-xs">
                                <p class="text-sm text-slate-600 truncate" title="{{ $link->original_url }}">{{ $link->original_url }}</p>
                            </td>
                            <td class="px-6 py-5 text-center">
                                @if($link->status === 'active')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-widest bg-emerald-50 text-emerald-600 border border-emerald-100">Active</span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-widest bg-slate-100 text-slate-400 border border-slate-200">Inactive</span>
                                @endif
                            </td>
                            <td class="px-6 py-5 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.links.edit', $link) }}" class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    <form method="POST" action="{{ route('admin.links.destroy', $link) }}" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" onclick="return confirm('Delete this link?')" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-20 text-center">
                                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                                </div>
                                <h4 class="text-lg font-bold text-slate-900 mb-1">No links found</h4>
                                <p class="text-sm text-slate-400 max-w-xs mx-auto">Try adjusting your filters or create your first shortlink to get started.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($links->hasPages())
            <div class="px-6 py-6 bg-slate-50/50 border-t border-slate-100">
                {{ $links->links() }}
            </div>
        @endif
    </div>

    <script>
        document.querySelector('[data-select-all]')?.addEventListener('change', function(e) {
            document.querySelectorAll('input[name="link_ids[]"]').forEach(cb => cb.checked = e.target.checked);
        });
    </script>
@endsection