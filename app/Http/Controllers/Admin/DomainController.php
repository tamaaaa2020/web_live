<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Domain;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DomainController extends Controller
{
    public function index(Request $request)
    {
        $domains = Domain::query()->orderByDesc('id')->paginate(25)->withQueryString();

        return view('admin.domains.index', [
            'domains' => $domains,
        ]);
    }

    public function create()
    {
        return view('admin.domains.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'domain_name' => [
                'required',
                'string',
                'max:255',
                'regex:/^([a-z0-9-]+\\.)+[a-z]{2,}$/i',
                'unique:domains,domain_name',
            ],
            'is_active' => ['nullable'],
        ]);

        Domain::create([
            'domain_name' => strtolower($data['domain_name']),
            'is_active' => (bool) ($data['is_active'] ?? false),
        ]);

        return redirect()->route('admin.domains.index');
    }

    public function edit(Domain $domain)
    {
        return view('admin.domains.edit', [
            'domain' => $domain,
        ]);
    }

    public function update(Request $request, Domain $domain)
    {
        $data = $request->validate([
            'domain_name' => [
                'required',
                'string',
                'max:255',
                'regex:/^([a-z0-9-]+\\.)+[a-z]{2,}$/i',
                Rule::unique('domains', 'domain_name')->ignore($domain->id),
            ],
            'is_active' => ['nullable'],
        ]);

        $domain->update([
            'domain_name' => strtolower($data['domain_name']),
            'is_active' => (bool) ($data['is_active'] ?? false),
        ]);

        return redirect()->route('admin.domains.index');
    }

    public function destroy(Domain $domain)
    {
        $domain->delete();

        return redirect()->route('admin.domains.index');
    }

    public function toggle(Domain $domain)
    {
        $domain->update(['is_active' => !$domain->is_active]);

        return redirect()->route('admin.domains.index');
    }
}

