<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('clicks_log')
            ->join('links', 'links.id', '=', 'clicks_log.link_id')
            ->select([
                'clicks_log.id',
                'clicks_log.created_at',
                'clicks_log.domain_source',
                'clicks_log.ip',
                'clicks_log.user_agent',
                'clicks_log.country',
                'clicks_log.referrer',
                'links.slug',
                'links.original_url',
            ])
            ->orderByDesc('clicks_log.id');

        $slug = trim((string) $request->query('slug', ''));
        if ($slug !== '') {
            $query->where('links.slug', 'like', "%{$slug}%");
        }

        $domain = trim((string) $request->query('domain', ''));
        if ($domain !== '') {
            $query->where('clicks_log.domain_source', 'like', "%{$domain}%");
        }

        $country = strtoupper(trim((string) $request->query('country', '')));
        if ($country !== '') {
            $query->where('clicks_log.country', $country);
        }

        $clicks = $query->paginate(50)->withQueryString();

        return view('admin.analytics.index', [
            'clicks' => $clicks,
            'slug' => $slug,
            'domain' => $domain,
            'country' => $country,
        ]);
    }
}

