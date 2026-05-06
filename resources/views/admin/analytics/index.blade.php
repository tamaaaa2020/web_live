@extends('admin.layout')

@section('title', 'Analytics')

@section('content')
    <div class="bg-white border border-slate-200 rounded-xl p-4">
        <form method="get" class="grid grid-cols-1 md:grid-cols-4 gap-3">
            <div>
                <label class="block text-xs text-slate-600">Slug</label>
                <input name="slug" value="{{ $slug }}" class="mt-1 w-full rounded-lg border-slate-300 focus:border-slate-500 focus:ring-slate-500" placeholder="promo.m4p">
            </div>
            <div>
                <label class="block text-xs text-slate-600">Domain Source</label>
                <input name="domain" value="{{ $domain }}" class="mt-1 w-full rounded-lg border-slate-300 focus:border-slate-500 focus:ring-slate-500" placeholder="example.com">
            </div>
            <div>
                <label class="block text-xs text-slate-600">Country</label>
                <input name="country" value="{{ $country }}" class="mt-1 w-full rounded-lg border-slate-300 focus:border-slate-500 focus:ring-slate-500" placeholder="ID">
            </div>
            <div class="flex items-end gap-2">
                <button class="px-4 py-2 rounded-lg bg-slate-900 text-white text-sm">Filter</button>
                <a href="{{ route('admin.analytics.index') }}" class="px-4 py-2 rounded-lg bg-white border border-slate-300 text-sm">Reset</a>
            </div>
        </form>
    </div>

    <div class="bg-white border border-slate-200 rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium">Time</th>
                        <th class="px-4 py-3 text-left font-medium">Slug</th>
                        <th class="px-4 py-3 text-left font-medium">Domain</th>
                        <th class="px-4 py-3 text-left font-medium">IP</th>
                        <th class="px-4 py-3 text-left font-medium">Country</th>
                        <th class="px-4 py-3 text-left font-medium">Referrer</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse ($clicks as $row)
                        <tr>
                            <td class="px-4 py-3 whitespace-nowrap text-xs text-slate-600">{{ $row->created_at }}</td>
                            <td class="px-4 py-3 font-medium">
                                <a href="/{{ $row->slug }}" target="_blank" class="underline underline-offset-4">{{ $row->slug }}</a>
                            </td>
                            <td class="px-4 py-3">{{ $row->domain_source }}</td>
                            <td class="px-4 py-3">{{ $row->ip }}</td>
                            <td class="px-4 py-3">{{ $row->country }}</td>
                            <td class="px-4 py-3 max-w-[360px] truncate" title="{{ $row->referrer }}">{{ $row->referrer }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-4 py-8 text-center text-slate-500" colspan="6">No clicks yet</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4">
            {{ $clicks->links() }}
        </div>
    </div>
@endsection

