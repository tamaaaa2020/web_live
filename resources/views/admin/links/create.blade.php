@extends('admin.layout')

@section('title', 'New Link')

@section('content')
    <div class="bg-white border border-slate-200 rounded-xl p-4 max-w-2xl">
        <form method="post" action="{{ route('admin.links.store') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs text-slate-600">Slug</label>
                <input name="slug" value="{{ old('slug') }}" class="mt-1 w-full rounded-lg border-slate-300 focus:border-slate-500 focus:ring-slate-500" placeholder="promo.m4p">
            </div>

            <div>
                <label class="block text-xs text-slate-600">Destination URL</label>
                <input name="original_url" value="{{ old('original_url') }}" class="mt-1 w-full rounded-lg border-slate-300 focus:border-slate-500 focus:ring-slate-500" placeholder="https://example.com/landing">
            </div>

            <div>
                <label class="block text-xs text-slate-600">Status</label>
                <select name="status" class="mt-1 w-full rounded-lg border-slate-300 focus:border-slate-500 focus:ring-slate-500">
                    <option value="active" @selected(old('status', 'active') === 'active')>active</option>
                    <option value="inactive" @selected(old('status') === 'inactive')>inactive</option>
                </select>
            </div>

            <div class="flex gap-2">
                <button class="px-4 py-2 rounded-lg bg-slate-900 text-white text-sm">Create</button>
                <a href="{{ route('admin.links.index') }}" class="px-4 py-2 rounded-lg bg-white border border-slate-300 text-sm">Cancel</a>
            </div>
        </form>
    </div>
@endsection

