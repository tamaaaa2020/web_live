@extends('admin.layout')

@section('title', 'Domain Manager')
@section('subtitle', 'Configure multiple domains and set up failover redirection.')

@section('content')
    <div class="mb-8 flex justify-end">
        <a href="{{ route('admin.domains.create') }}" class="inline-flex items-center justify-center bg-blue-600 text-white px-6 py-3 rounded-2xl text-sm font-bold hover:bg-blue-700 transition-colors shadow-lg shadow-blue-500/20">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Add New Domain
        </a>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Domain Name</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest text-center">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Failover To</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse ($domains as $domain)
                        <tr class="hover:bg-slate-50/30 transition-colors">
                            <td class="px-6 py-5">
                                <span class="text-sm font-bold text-slate-900">{{ $domain->domain_name }}</span>
                            </td>
                            <td class="px-6 py-5 text-center">
                                @if($domain->is_active)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-widest bg-emerald-50 text-emerald-600 border border-emerald-100">Active</span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-widest bg-slate-100 text-slate-400 border border-slate-200">Inactive</span>
                                @endif
                            </td>
                            <td class="px-6 py-5">
                                @if ($domain->failoverTarget)
                                    <div class="flex items-center gap-2">
                                        <span class="text-xs font-bold text-slate-700">{{ $domain->failoverTarget->domain_name }}</span>
                                        <span class="text-[9px] font-black uppercase text-slate-400 bg-slate-50 px-1.5 py-0.5 rounded border border-slate-100">
                                            {{ $domain->failoverTarget->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </div>
                                @else
                                    <span class="text-xs text-slate-300 font-medium italic">No failover set</span>
                                @endif
                            </td>
                            <td class="px-6 py-5 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <form method="POST" action="{{ route('admin.domains.toggle', $domain) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="text-xs font-bold px-3 py-1.5 rounded-lg {{ $domain->is_active ? 'text-slate-400 hover:text-slate-600' : 'text-blue-600 hover:bg-blue-50' }} transition-all">
                                            {{ $domain->is_active ? 'Disable' : 'Enable' }}
                                        </button>
                                    </form>
                                    <a href="{{ route('admin.domains.edit', $domain) }}" class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    <form method="POST" action="{{ route('admin.domains.destroy', $domain) }}" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" onclick="return confirm('Delete this domain?')" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-20 text-center">
                                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                                </div>
                                <h4 class="text-lg font-bold text-slate-900 mb-1">No domains added</h4>
                                <p class="text-sm text-slate-400 max-w-xs mx-auto">Add your first domain to start redirecting traffic.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($domains->hasPages())
            <div class="px-6 py-6 bg-slate-50/50 border-t border-slate-100">
                {{ $domains->links() }}
            </div>
        @endif
    </div>
@endsection