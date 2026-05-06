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
        $domains = Domain::query()
            ->with(['failoverTarget:id,domain_name,is_active'])
            ->orderByDesc('id')
            ->paginate(25)
            ->withQueryString();

        return view('admin.domains.index', [
            'domains' => $domains,
        ]);
    }

    public function create()
    {
        $failoverTargets = Domain::query()
            ->select(['id', 'domain_name', 'is_active'])
            ->orderBy('domain_name')
            ->get();

        return view('admin.domains.create', [
            'failoverTargets' => $failoverTargets,
        ]);
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
            'failover_to_domain_id' => ['nullable', 'integer', 'exists:domains,id'],
        ]);

        Domain::create([
            'domain_name' => strtolower($data['domain_name']),
            'is_active' => (bool) ($data['is_active'] ?? false),
            'failover_to_domain_id' => $data['failover_to_domain_id'] ?? null,
        ]);

        return redirect()->route('admin.domains.index');
    }

    public function edit(Domain $domain)
    {
        $failoverTargets = Domain::query()
            ->select(['id', 'domain_name', 'is_active'])
            ->where('id', '!=', $domain->id)
            ->orderBy('domain_name')
            ->get();

        return view('admin.domains.edit', [
            'domain' => $domain,
            'failoverTargets' => $failoverTargets,
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
            'failover_to_domain_id' => ['nullable', 'integer', 'exists:domains,id'],
        ]);

        $domain->update([
            'domain_name' => strtolower($data['domain_name']),
            'is_active' => (bool) ($data['is_active'] ?? false),
            'failover_to_domain_id' => $data['failover_to_domain_id'] ?? null,
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
