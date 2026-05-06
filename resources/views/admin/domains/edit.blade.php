@extends('admin.layout')

@section('title', 'Edit Domain')

@section('content')
    <div class="bg-white border border-slate-200 rounded-xl p-4 max-w-2xl">
        <form method="post" action="{{ route('admin.domains.update', $domain) }}" class="space-y-4">
            @csrf
            @method('put')

            <div>
                <label class="block text-xs text-slate-600">Domain Name</label>
                <input name="domain_name" value="{{ old('domain_name', $domain->domain_name) }}" class="mt-1 w-full rounded-lg border-slate-300 focus:border-slate-500 focus:ring-slate-500">
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" value="1" class="rounded border-slate-300 text-slate-900 focus:ring-slate-500" @checked(old('is_active', $domain->is_active ? '1' : '0') === '1')>
                <label class="text-sm text-slate-700">Active</label>
            </div>

            <div class="flex gap-2">
                <button class="px-4 py-2 rounded-lg bg-slate-900 text-white text-sm">Save</button>
                <a href="{{ route('admin.domains.index') }}" class="px-4 py-2 rounded-lg bg-white border border-slate-300 text-sm">Back</a>
            </div>
        </form>
    </div>
@endsection

