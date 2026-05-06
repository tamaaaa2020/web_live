@extends('admin.layout')

@section('title', 'Analytics')

@section('content')
    <div class="mb-4">
        <form method="get" class="grid grid-cols-1 md:grid-cols-4 gap-3 bg-white p-4 rounded-lg shadow dark:bg-gray-800">
            <div>
                <label for="slug-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Slug</label>
                <input type="text" id="slug-input" name="slug" value="{{ $slug }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="promo.mp4">
            </div>
            <div>
                <label for="domain-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Domain Source</label>
                <input type="text" id="domain-input" name="domain" value="{{ $domain }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="example.com">
            </div>
            <div>
                <label for="country-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Country</label>
                <input type="text" id="country-input" name="country" value="{{ $country }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="ID">
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Filter</button>
                <a href="{{ route('admin.analytics.index') }}" class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Reset</a>
            </div>
        </form>
    </div>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">Time</th>
                    <th scope="col" class="px-6 py-3">Slug</th>
                    <th scope="col" class="px-6 py-3">Domain</th>
                    <th scope="col" class="px-6 py-3">IP</th>
                    <th scope="col" class="px-6 py-3">Country</th>
                    <th scope="col" class="px-6 py-3">Referrer</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($clicks as $row)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-white">{{ $row->created_at }}</td>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            <a href="/{{ $row->slug }}" target="_blank" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">{{ $row->slug }}</a>
                        </th>
                        <td class="px-6 py-4">{{ $row->domain_source }}</td>
                        <td class="px-6 py-4">{{ $row->ip }}</td>
                        <td class="px-6 py-4">{{ $row->country }}</td>
                        <td class="px-6 py-4 max-w-[360px] truncate" title="{{ $row->referrer }}">{{ $row->referrer }}</td>
                    </tr>
                @empty
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">No clicks yet</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <nav class="flex items-center flex-column flex-wrap md:flex-row justify-between pt-4" aria-label="Table navigation">
            {{ $clicks->links() }}
        </nav>
    </div>
@endsection

