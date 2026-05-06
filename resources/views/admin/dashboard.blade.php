@extends('admin.layout')

@section('title', 'Overview')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white border border-slate-200 rounded-xl p-4">
            <div class="text-xs text-slate-500">Total Clicks</div>
            <div class="text-2xl font-semibold mt-1">{{ number_format($totalClicks) }}</div>
        </div>
        <div class="bg-white border border-slate-200 rounded-xl p-4 md:col-span-2">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-sm font-semibold">Daily Clicks</div>
                    <div class="text-xs text-slate-500">Last 14 days</div>
                </div>
            </div>

            @php
                $max = 0;
                foreach ($daily as $row) {
                    $max = max($max, (int) $row['clicks']);
                }
                $max = max($max, 1);
            @endphp

            <div class="mt-4 space-y-2">
                @foreach ($daily as $row)
                    @php
                        $pct = (int) round(((int) $row['clicks'] / $max) * 100);
                    @endphp
                    <div class="flex items-center gap-3">
                        <div class="w-24 text-xs text-slate-500">{{ $row['day'] }}</div>
                        <div class="flex-1 bg-slate-100 rounded-full h-2 overflow-hidden">
                            <div class="bg-slate-900 h-2" style="width: {{ $pct }}%"></div>
                        </div>
                        <div class="w-12 text-right text-xs text-slate-700">{{ $row['clicks'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="bg-white border border-slate-200 rounded-xl overflow-hidden">
        <div class="px-4 py-3 border-b border-slate-200 flex items-center justify-between">
            <div>
                <div class="text-sm font-semibold">Top Links</div>
                <div class="text-xs text-slate-500">All-time clicks</div>
            </div>
            <a href="{{ route('admin.links.index') }}" class="text-sm text-slate-900 underline underline-offset-4">Manage Links</a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="text-left font-medium px-4 py-3">Slug</th>
                        <th class="text-left font-medium px-4 py-3">Destination</th>
                        <th class="text-right font-medium px-4 py-3">Clicks</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse ($topLinks as $row)
                        <tr>
                            <td class="px-4 py-3 font-medium">{{ $row->slug }}</td>
                            <td class="px-4 py-3">
                                <a href="{{ $row->original_url }}" target="_blank" class="text-slate-900 underline underline-offset-4">
                                    {{ $row->original_url }}
                                </a>
                            </td>
                            <td class="px-4 py-3 text-right">{{ number_format($row->clicks) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-4 py-6 text-center text-slate-500" colspan="3">No data yet</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

