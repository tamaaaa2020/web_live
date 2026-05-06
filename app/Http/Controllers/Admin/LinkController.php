<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LinkController extends Controller
{
    public function index(Request $request)
    {
        $query = Link::query()->orderByDesc('id');

        $search = trim((string) $request->query('q', ''));
        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('slug', 'like', "%{$search}%")
                    ->orWhere('original_url', 'like', "%{$search}%");
            });
        }

        $status = trim((string) $request->query('status', ''));
        if ($status !== '') {
            $query->where('status', $status);
        }

        $links = $query->paginate(25)->withQueryString();

        return view('admin.links.index', [
            'links' => $links,
            'search' => $search,
            'status' => $status,
        ]);
    }

    public function create()
    {
        return view('admin.links.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'slug' => ['required', 'string', 'max:255', 'regex:/^[A-Za-z0-9._-]+$/', 'unique:links,slug'],
            'original_url' => ['required', 'string', 'max:2048', 'url'],
            'status' => ['required', 'string', Rule::in(['active', 'inactive'])],
        ]);

        Link::create($data);

        return redirect()->route('admin.links.index');
    }

    public function edit(Link $link)
    {
        return view('admin.links.edit', [
            'link' => $link,
        ]);
    }

    public function update(Request $request, Link $link)
    {
        $data = $request->validate([
            'slug' => [
                'required',
                'string',
                'max:255',
                'regex:/^[A-Za-z0-9._-]+$/',
                Rule::unique('links', 'slug')->ignore($link->id),
            ],
            'original_url' => ['required', 'string', 'max:2048', 'url'],
            'status' => ['required', 'string', Rule::in(['active', 'inactive'])],
        ]);

        $link->update($data);

        return redirect()->route('admin.links.index');
    }

    public function destroy(Link $link)
    {
        $link->delete();

        return redirect()->route('admin.links.index');
    }

    public function bulkUpdateDestination(Request $request)
    {
        $data = $request->validate([
            'link_ids' => ['required', 'array', 'min:1'],
            'link_ids.*' => ['integer'],
            'destination_url' => ['required', 'string', 'max:2048', 'url'],
        ]);

        Link::query()
            ->whereIn('id', $data['link_ids'])
            ->update(['original_url' => $data['destination_url']]);

        return redirect()->route('admin.links.index');
    }
}

