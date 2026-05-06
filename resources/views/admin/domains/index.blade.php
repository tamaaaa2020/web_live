@extends('admin.layout')

@section('title', 'Domain Manager')

@section('content')
    <div class="flex flex-col gap-4">
        <div class="flex justify-end">
            <a href="{{ route('admin.domains.create') }}" class="px-4 py-2 rounded-lg bg-white border border-slate-300 text-sm">New Domain</a>
        </div>

        <div class="bg-white border border-slate-200 rounded-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-50 text-slate-600">
                        <tr>
                            <th class="px-4 py-3 text-left font-medium">Domain</th>
                            <th class="px-4 py-3 text-left font-medium">Status</th>
                            <th class="px-4 py-3 text-right font-medium">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse ($domains as $domain)
                            <tr>
                                <td class="px-4 py-3 font-medium">{{ $domain->domain_name }}</td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs {{ $domain->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-700' }}">
                                        {{ $domain->is_active ? 'active' : 'inactive' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-right whitespace-nowrap">
                                    <form method="post" action="{{ route('admin.domains.toggle', $domain) }}" class="inline">
                                        @csrf
                                        <button class="text-sm underline underline-offset-4">{{ $domain->is_active ? 'Disable' : 'Enable' }}</button>
                                    </form>
                                    <a href="{{ route('admin.domains.edit', $domain) }}" class="ml-3 text-sm underline underline-offset-4">Edit</a>
                                    <form method="post" action="{{ route('admin.domains.destroy', $domain) }}" class="inline">
                                        @csrf
                                        @method('delete')
                                        <button class="ml-3 text-sm text-red-700 underline underline-offset-4" onclick="return confirm('Delete this domain?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="px-4 py-8 text-center text-slate-500" colspan="3">No domains yet</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-4">
                {{ $domains->links() }}
            </div>
        </div>
    </div>
@endsection

