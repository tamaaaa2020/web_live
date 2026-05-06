@extends('admin.layout')

@section('title', 'Domain Manager')

@section('content')
    <div class="mb-4">
        <div class="flex justify-end">
            <a href="{{ route('admin.domains.create') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">New Domain</a>
        </div>
    </div>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">Domain</th>
                    <th scope="col" class="px-6 py-3">Status</th>
                    <th scope="col" class="px-6 py-3">Failover To</th>
                    <th scope="col" class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($domains as $domain)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $domain->domain_name }}</th>
                        <td class="px-6 py-4">
                            <span class="bg-{{ $domain->is_active ? 'green' : 'red' }}-100 text-{{ $domain->is_active ? 'green' : 'red' }}-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-{{ $domain->is_active ? 'green' : 'red' }}-900 dark:text-{{ $domain->is_active ? 'green' : 'red' }}-300">
                                {{ $domain->is_active ? 'active' : 'inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if ($domain->failoverTarget)
                                <span class="font-medium text-gray-900 dark:text-white">{{ $domain->failoverTarget->domain_name }}</span>
                                <span class="bg-{{ $domain->failoverTarget->is_active ? 'green' : 'red' }}-100 text-{{ $domain->failoverTarget->is_active ? 'green' : 'red' }}-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-{{ $domain->failoverTarget->is_active ? 'green' : 'red' }}-900 dark:text-{{ $domain->failoverTarget->is_active ? 'green' : 'red' }}-300">
                                    ({{ $domain->failoverTarget->is_active ? 'active' : 'inactive' }})
                                </span>
                            @else
                                <span class="text-gray-500 dark:text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <form method="post" action="{{ route('admin.domains.toggle', $domain) }}" class="inline-block">
                                @csrf
                                <button type="submit" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">{{ $domain->is_active ? 'Disable' : 'Enable' }}</button>
                            </form>
                            <a href="{{ route('admin.domains.edit', $domain) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline ml-3">Edit</a>
                            <form method="post" action="{{ route('admin.domains.destroy', $domain) }}" class="inline-block ml-3">
                                @csrf
                                @method('delete')
                                <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline" onclick="return confirm('Delete this domain?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">No domains yet</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <nav class="flex items-center flex-column flex-wrap md:flex-row justify-between pt-4" aria-label="Table navigation">
            {{ $domains->links() }}
        </nav>
    </div>
@endsection
