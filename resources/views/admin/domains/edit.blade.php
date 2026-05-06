@extends('admin.layout')

@section('title', 'Edit Domain')
@section('subtitle', 'Update domain configuration and failover settings.')

@section('content')
    <div class="max-w-2xl">
        <div class="bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-sm">
            <form method="POST" action="{{ route('admin.domains.update', $domain) }}" class="space-y-8">
                @csrf @method('PUT')

                <div>
                    <label for="domain_name" class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-3 px-1">Domain Name</label>
                    <input type="text" id="domain_name" name="domain_name" value="{{ old('domain_name', $domain->domain_name) }}" required
                        class="block w-full rounded-2xl border-slate-100 bg-slate-50/50 px-5 py-4 text-slate-900 text-sm font-medium focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all placeholder:text-slate-400">
                </div>

                <div class="flex items-center group cursor-pointer w-fit">
                    <input id="is_active" name="is_active" type="checkbox" value="1" @checked(old('is_active', $domain->is_active ? '1' : '0') === '1')
                        class="w-6 h-6 rounded-lg border-slate-200 text-blue-600 focus:ring-blue-500/20 transition-all cursor-pointer">
                    <label for="is_active" class="ml-4 text-sm font-bold text-slate-700 cursor-pointer">Domain is Active</label>
                </div>

                <div>
                    <label for="failover_to_domain_id" class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-3 px-1">Failover Destination</label>
                    <select id="failover_to_domain_id" name="failover_to_domain_id" class="block w-full rounded-2xl border-slate-100 bg-slate-50/50 px-5 py-4 text-slate-900 text-sm font-medium focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all">
                        <option value="">No Failover</option>
                        @foreach ($failoverTargets as $target)
                            <option value="{{ $target->id }}" @selected((string) old('failover_to_domain_id', $domain->failover_to_domain_id) === (string) $target->id)>
                                {{ $target->domain_name }} ({{ $target->is_active ? 'Active' : 'Inactive' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="pt-4 flex items-center gap-4">
                    <button type="submit" class="flex-1 bg-slate-900 text-white py-4 rounded-2xl text-sm font-bold hover:bg-slate-800 transition-all shadow-lg shadow-slate-900/10 active:scale-[0.98]">
                        Save Changes
                    </button>
                    <a href="{{ route('admin.domains.index') }}" class="px-8 py-4 text-slate-500 text-sm font-bold hover:text-slate-900 transition-colors">
                        Back
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection