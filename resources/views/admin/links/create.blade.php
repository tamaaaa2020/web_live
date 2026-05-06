@extends('admin.layout')

@section('title', 'New Link')

@section('content')
    <div class="bg-white border border-gray-200 rounded-xl p-4 max-w-2xl dark:bg-gray-800 dark:border-gray-700">
        <form method="post" action="{{ route('admin.links.store') }}" class="space-y-4">
            @csrf

            <div>
                <label for="slug-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Slug (optional)</label>
                <div class="flex">
                    <input type="text" id="slug-input" name="slug" value="{{ old('slug') }}" class="rounded-none rounded-s-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="kosongkan untuk auto random *.mp4">
                    <button type="button" id="generate-slug-btn" class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-s-0 border-gray-300 rounded-e-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                        Generate
                    </button>
                </div>
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Kalau dikosongkan, sistem auto-generate slug random dengan akhiran .mp4 (itu cuma format slug, bukan file mp4 beneran).</p>
            </div>

            <div>
                <label for="original-url-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Destination URL</label>
                <input type="url" id="original-url-input" name="original_url" value="{{ old('original_url') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="https://example.com/landing">
            </div>

            <div>
                <label for="status-select" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                <select id="status-select" name="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="active" @selected(old('status', 'active') === 'active')>active</option>
                    <option value="inactive" @selected(old('status') === 'inactive')>inactive</option>
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Create</button>
                <a href="{{ route('admin.links.index') }}" class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Cancel</a>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const generateSlugBtn = document.getElementById('generate-slug-btn');
                const slugInput = document.getElementById('slug-input');

                if (generateSlugBtn && slugInput) {
                    generateSlugBtn.addEventListener('click', function() {
                        const randomString = Math.random().toString(36).substring(2, 10); // 8 random chars
                        slugInput.value = randomString + '.mp4';
                    });
                }
            });
        </script>
    @endpush
@endsection
