@extends('admin.layout')

@section('title', 'Add New Domain')
@section('subtitle', 'Register a new domain to use for your shortlinks.')

@section('content')
    <div class="max-w-2xl">
        <div class="bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-sm">
            <form method="POST" action="{{ route('admin.domains.store') }}" class="space-y-8">
                @csrf

                <div>
                    <label for="domain_name" class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-3 px-1">Domain Name</label>
                    <input type="text" id="domain_name" name="domain_name" value="{{ old('domain_name') }}" required
                        class="block w-full rounded-2xl border-slate-100 bg-slate-50/50 px-5 py-4 text-slate-900 text-sm font-medium focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all placeholder:text-slate-400" 
                        placeholder="e.g. myshortlink.com">
                </div>

                <div class="flex items-center group cursor-pointer w-fit">
                    <input id="is_active" name="is_active" type="checkbox" value="1" @checked(old('is_active', '1') === '1')
                        class="w-6 h-6 rounded-lg border-slate-200 text-blue-600 focus:ring-blue-500/20 transition-all cursor-pointer">
                    <label for="is_active" class="ml-4 text-sm font-bold text-slate-700 cursor-pointer">Mark as Active</label>
                </div>

                <div>
                    <label for="failover_to_domain_id" class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-3 px-1">Failover Destination (Optional)</label>
                    <select id="failover_to_domain_id" name="failover_to_domain_id" class="block w-full rounded-2xl border-slate-100 bg-slate-50/50 px-5 py-4 text-slate-900 text-sm font-medium focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all">
                        <option value="">No Failover</option>
                        @foreach ($failoverTargets as $target)
                            <option value="{{ $target->id }}" @selected((string) old('failover_to_domain_id') === (string) $target->id)>
                                {{ $target->domain_name }} ({{ $target->is_active ? 'Active' : 'Inactive' }})
                            </option>
                        @endforeach
                    </select>
                    <p class="mt-3 text-xs text-slate-400 font-medium px-1 italic">If this domain is disabled, traffic will automatically redirect to the selected failover domain.</p>
                </div>

                <div class="pt-4 flex items-center gap-4">
                    <button type="submit" class="flex-1 bg-blue-600 text-white py-4 rounded-2xl text-sm font-bold hover:bg-blue-700 transition-all shadow-lg shadow-blue-500/20 active:scale-[0.98]">
                        Add Domain
                    </button>
                    <a href="{{ route('admin.domains.index') }}" class="px-8 py-4 text-slate-500 text-sm font-bold hover:text-slate-900 transition-colors">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection