@extends('admin.layout')

@section('title', 'Overview')

@section('content')
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
        <div class="w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
            <div class="flex justify-between">
                <div>
                    <h5 class="leading-none text-3xl font-bold text-gray-900 dark:text-white pb-2">{{ number_format($totalClicks) }}</h5>
                    <p class="text-base font-normal text-gray-500 dark:text-gray-400">Total Clicks</p>
                </div>
            </div>
        </div>
    </div>

    <div class="w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6 mb-4">
        <div class="flex justify-between mb-3">
            <div class="flex justify-center items-center">
                <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white pe-1">Daily Clicks</h5>
                <a href="#" class="font-semibold text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                    Last 14 days
                </a>
            </div>
        </div>

        @php
            $max = 0;
            foreach ($daily as $row) {
                $max = max($max, (int) $row['clicks']);
            }
            $max = max($max, 1);
        @endphp

        <div class="grid grid-cols-1 gap-4">
            @foreach ($daily as $row)
                @php
                    $pct = (int) round(((int) $row['clicks'] / $max) * 100);
                @endphp
                <div class="flex items-center gap-3">
                    <div class="w-24 text-xs text-gray-500 dark:text-gray-400">{{ $row['day'] }}</div>
                    <div class="flex-1 w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                        <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $pct }}%"></div>
                    </div>
                    <div class="w-12 text-right text-xs text-gray-700 dark:text-gray-300">{{ $row['clicks'] }}</div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6">
        <div class="flex justify-between items-center mb-4">
            <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white">Top Links</h5>
            <a href="{{ route('admin.links.index') }}" class="text-sm font-medium text-blue-600 hover:underline dark:text-blue-500">
                Manage Links
            </a>
        </div>
        <div class="flow-root">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">Slug</th>
                            <th scope="col" class="px-6 py-3">Destination</th>
                            <th scope="col" class="px-6 py-3 text-right">Clicks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($topLinks as $row)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $row->slug }}</th>
                                <td class="px-6 py-4">
                                    <a href="{{ $row->original_url }}" target="_blank" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                        {{ $row->original_url }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 text-right">{{ number_format($row->clicks) }}</td>
                            </tr>
                        @empty
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td colspan="3" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">No data yet</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

