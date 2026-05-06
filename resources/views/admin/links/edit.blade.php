@extends('admin.layout')

@section('title', 'Edit Link')
@section('subtitle', 'Update your shortlink destination or status.')

@section('content')
    <div class="max-w-2xl">
        <div class="bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-sm">
            <form method="POST" action="{{ route('admin.links.update', $link) }}" class="space-y-8">
                @csrf @method('PUT')

                <div>
                    <label for="slug" class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-3 px-1">Short Slug</label>
                    <div class="flex gap-2">
                        <input type="text" id="slug" name="slug" value="{{ old('slug', $link->slug) }}" 
                            class="block w-full rounded-2xl border-slate-100 bg-slate-50/50 px-5 py-4 text-slate-900 text-sm font-medium focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all placeholder:text-slate-400" 
                            placeholder="e.g. promo-2024">
                        <button type="button" id="gen-slug" class="px-6 bg-slate-100 text-slate-600 rounded-2xl text-xs font-bold hover:bg-slate-200 transition-colors whitespace-nowrap">
                            Generate
                        </button>
                    </div>
                </div>

                <div>
                    <label for="original_url" class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-3 px-1">Destination URL</label>
                    <input type="url" id="original_url" name="original_url" value="{{ old('original_url', $link->original_url) }}" required
                        class="block w-full rounded-2xl border-slate-100 bg-slate-50/50 px-5 py-4 text-slate-900 text-sm font-medium focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all placeholder:text-slate-400">
                </div>

                <div>
                    <label for="status" class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-3 px-1">Status</label>
                    <select id="status" name="status" class="block w-full rounded-2xl border-slate-100 bg-slate-50/50 px-5 py-4 text-slate-900 text-sm font-medium focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all">
                        <option value="active" @selected(old('status', $link->status) === 'active')>Active</option>
                        <option value="inactive" @selected(old('status', $link->status) === 'inactive')>Inactive</option>
                    </select>
                </div>

                <div class="pt-4 flex items-center gap-4">
                    <button type="submit" class="flex-1 bg-slate-900 text-white py-4 rounded-2xl text-sm font-bold hover:bg-slate-800 transition-all shadow-lg shadow-slate-900/10 active:scale-[0.98]">
                        Update Link
                    </button>
                    <a href="{{ route('admin.links.index') }}" class="px-8 py-4 text-slate-500 text-sm font-bold hover:text-slate-900 transition-colors">
                        Back
                    </a>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        document.getElementById('gen-slug')?.addEventListener('click', function() {
            const random = Math.random().toString(36).substring(2, 10);
            document.getElementById('slug').value = random + '.mp4';
        });
    </script>
    @endpush
@endsection