@extends('admin.layout')

@section('title', 'New Domain')

@section('content')
    <div class="bg-white border border-gray-200 rounded-xl p-4 max-w-2xl dark:bg-gray-800 dark:border-gray-700">
        <form method="post" action="{{ route('admin.domains.store') }}" class="space-y-4">
            @csrf

            <div>
                <label for="domain-name-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Domain Name</label>
                <input type="text" id="domain-name-input" name="domain_name" value="{{ old('domain_name') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="example.com">
            </div>

            <div class="flex items-center">
                <input id="is-active-checkbox" type="checkbox" name="is_active" value="1" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" @checked(old('is_active', '1') === '1')>
                <label for="is-active-checkbox" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Active</label>
            </div>

            <div>
                <label for="failover-select" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Failover To (optional)</label>
                <select id="failover-select" name="failover_to_domain_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="">None</option>
                    @foreach ($failoverTargets as $target)
                        <option value="{{ $target->id }}" @selected((string) old('failover_to_domain_id') === (string) $target->id)>
                            {{ $target->domain_name }}{{ $target->is_active ? '' : ' (inactive)' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Create</button>
                <a href="{{ route('admin.domains.index') }}" class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Cancel</a>
            </div>
        </form>
    </div>
@endsection
