@extends('admin.layout')

@section('title', 'Link Manager')

@section('content')
    <div class="mb-4">
        <form method="get" class="flex flex-col md:flex-row md:items-end gap-3 bg-white p-4 rounded-lg shadow dark:bg-gray-800">
            <div class="flex-1">
                <label for="search-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Search</label>
                <input type="text" id="search-input" name="q" value="{{ $search }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="slug / destination url">
            </div>
            <div class="w-full md:w-48">
                <label for="status-select" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                <select id="status-select" name="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="">All</option>
                    <option value="active" @selected($status === 'active')>active</option>
                    <option value="inactive" @selected($status === 'inactive')>inactive</option>
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Filter</button>
                <a href="{{ route('admin.links.create') }}" class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">New Link</a>
            </div>
        </form>
    </div>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <form method="post" action="{{ route('admin.links.bulkUpdateDestination') }}">
            @csrf
            <div class="flex items-center justify-between flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-4 bg-white dark:bg-gray-900 p-4">
                <label for="bulk-update-destination" class="sr-only">Bulk Update Destination URL</label>
                <div class="relative">
                    <input type="text" id="bulk-update-destination" name="destination_url" class="block p-2.5 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="https://destination.example/path">
                </div>
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Update Selected</button>
            </div>

            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="p-4">
                            <div class="flex items-center">
                                <input id="checkbox-all-search" type="checkbox" data-select-all class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-all-search" class="sr-only">checkbox</label>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3">Slug</th>
                        <th scope="col" class="px-6 py-3">Destination</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($links as $link)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="w-4 p-4">
                                <div class="flex items-center">
                                    <input id="checkbox-table-search-{{ $link->id }}" type="checkbox" name="link_ids[]" value="{{ $link->id }}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="checkbox-table-search-{{ $link->id }}" class="sr-only">checkbox</label>
                                </div>
                            </td>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <a href="/{{ $link->slug }}" target="_blank" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">{{ $link->slug }}</a>
                            </th>
                            <td class="px-6 py-4">
                                <a href="{{ $link->original_url }}" target="_blank" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">{{ $link->original_url }}</a>
                            </td>
                            <td class="px-6 py-4">
                                <span class="bg-{{ $link->status === 'active' ? 'green' : 'red' }}-100 text-{{ $link->status === 'active' ? 'green' : 'red' }}-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-{{ $link->status === 'active' ? 'green' : 'red' }}-900 dark:text-{{ $link->status === 'active' ? 'green' : 'red' }}-300">
                                    {{ $link->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.links.edit', $link) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                                <form method="post" action="{{ route('admin.links.destroy', $link) }}" class="inline-block ml-3">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline" onclick="return confirm('Delete this link?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">No links yet</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </form>
        <nav class="flex items-center flex-column flex-wrap md:flex-row justify-between pt-4" aria-label="Table navigation">
            {{ $links->links() }}
        </nav>
    </div>
@endsection

