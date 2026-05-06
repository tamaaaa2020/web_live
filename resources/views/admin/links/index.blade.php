@extends('admin.layout')

@section('title', 'Link Manager')

@section('content')
    <div class="flex flex-col gap-4">
        <div class="bg-white border border-slate-200 rounded-xl p-4">
            <form method="get" class="flex flex-col md:flex-row md:items-end gap-3">
                <div class="flex-1">
                    <label class="block text-xs text-slate-600">Search</label>
                    <input name="q" value="{{ $search }}" class="mt-1 w-full rounded-lg border-slate-300 focus:border-slate-500 focus:ring-slate-500" placeholder="slug / destination url">
                </div>
                <div class="w-full md:w-48">
                    <label class="block text-xs text-slate-600">Status</label>
                    <select name="status" class="mt-1 w-full rounded-lg border-slate-300 focus:border-slate-500 focus:ring-slate-500">
                        <option value="">All</option>
                        <option value="active" @selected($status === 'active')>active</option>
                        <option value="inactive" @selected($status === 'inactive')>inactive</option>
                    </select>
                </div>
                <div class="flex gap-2">
                    <button class="px-4 py-2 rounded-lg bg-slate-900 text-white text-sm">Filter</button>
                    <a href="{{ route('admin.links.create') }}" class="px-4 py-2 rounded-lg bg-white border border-slate-300 text-sm">New Link</a>
                </div>
            </form>
        </div>

        <div class="bg-white border border-slate-200 rounded-xl overflow-hidden">
            <div class="px-4 py-3 border-b border-slate-200">
                <form method="post" action="{{ route('admin.links.bulkUpdateDestination') }}" class="flex flex-col md:flex-row gap-2 md:items-center">
                    @csrf
                    <div class="text-sm font-semibold flex-1">Bulk Update Destination URL</div>
                    <input name="destination_url" class="w-full md:w-[520px] rounded-lg border-slate-300 focus:border-slate-500 focus:ring-slate-500" placeholder="https://destination.example/path">
                    <button class="px-4 py-2 rounded-lg bg-slate-900 text-white text-sm">Update Selected</button>
                </form>
            </div>

            <div class="overflow-x-auto">
                <form method="post" action="{{ route('admin.links.bulkUpdateDestination') }}">
                    @csrf
                    <table class="min-w-full text-sm">
                        <thead class="bg-slate-50 text-slate-600">
                            <tr>
                                <th class="px-4 py-3 text-left font-medium">
                                    <input type="checkbox" data-select-all class="rounded border-slate-300 text-slate-900 focus:ring-slate-500">
                                </th>
                                <th class="px-4 py-3 text-left font-medium">Slug</th>
                                <th class="px-4 py-3 text-left font-medium">Destination</th>
                                <th class="px-4 py-3 text-left font-medium">Status</th>
                                <th class="px-4 py-3 text-right font-medium">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @forelse ($links as $link)
                                <tr>
                                    <td class="px-4 py-3">
                                        <input type="checkbox" name="link_ids[]" value="{{ $link->id }}" class="rounded border-slate-300 text-slate-900 focus:ring-slate-500">
                                    </td>
                                    <td class="px-4 py-3 font-medium">
                                        <a href="/{{ $link->slug }}" target="_blank" class="underline underline-offset-4">{{ $link->slug }}</a>
                                    </td>
                                    <td class="px-4 py-3">
                                        <a href="{{ $link->original_url }}" target="_blank" class="underline underline-offset-4">{{ $link->original_url }}</a>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs {{ $link->status === 'active' ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-700' }}">
                                            {{ $link->status }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-right whitespace-nowrap">
                                        <a href="{{ route('admin.links.edit', $link) }}" class="text-sm underline underline-offset-4">Edit</a>
                                        <form method="post" action="{{ route('admin.links.destroy', $link) }}" class="inline">
                                            @csrf
                                            @method('delete')
                                            <button class="ml-3 text-sm text-red-700 underline underline-offset-4" onclick="return confirm('Delete this link?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="px-4 py-8 text-center text-slate-500" colspan="5">No links yet</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="p-4 border-t border-slate-200 flex flex-col md:flex-row gap-2 md:items-center">
                        <div class="flex-1 text-xs text-slate-500">Select links above, then set destination URL</div>
                        <input name="destination_url" class="w-full md:w-[520px] rounded-lg border-slate-300 focus:border-slate-500 focus:ring-slate-500" placeholder="https://destination.example/path">
                        <button class="px-4 py-2 rounded-lg bg-slate-900 text-white text-sm">Update Selected</button>
                    </div>
                </form>
            </div>

            <div class="p-4">
                {{ $links->links() }}
            </div>
        </div>
    </div>
@endsection

