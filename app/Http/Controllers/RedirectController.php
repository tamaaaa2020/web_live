<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class RedirectController extends Controller
{
    public function __invoke(Request $request, string $slug)
    {
        $slug = trim($slug);

        if ($slug === '') {
            abort(404);
        }

        $userAgent = (string) $request->userAgent();

        if ($this->isBlockedUserAgent($userAgent)) {
            abort(404);
        }

        $host = strtolower((string) $request->getHost());

        if (!app()->environment('local')) {
            $anyDomains = Cache::remember(
                'domains:any',
                now()->addMinutes(5),
                fn () => DB::table('domains')->exists()
            );

            if ($anyDomains) {
                $domain = Cache::remember(
                    "domain_host:{$host}",
                    now()->addMinutes(5),
                    fn () => DB::table('domains')
                        ->select(['id', 'is_active', 'failover_to_domain_id'])
                        ->where('domain_name', $host)
                        ->first()
                );

                if (!$domain) {
                    abort(404);
                }

                if (!(bool) ($domain->is_active ?? false)) {
                    $targetId = $domain->failover_to_domain_id ?? null;

                    if ($targetId) {
                        $target = Cache::remember(
                            "domain_id:{$targetId}",
                            now()->addMinutes(5),
                            fn () => DB::table('domains')
                                ->select(['id', 'domain_name', 'is_active'])
                                ->where('id', $targetId)
                                ->first()
                        );

                        if ($target && (bool) $target->is_active) {
                            $query = $request->query();
                            $query['__src'] = $host;
                            $query['__fs'] = 1;

                            $url = $request->getScheme().'://'.$target->domain_name.'/'.$slug;
                            $qs = http_build_query($query);

                            if ($qs !== '') {
                                $url .= '?'.$qs;
                            }

                            return redirect()->away($url, 302);
                        }
                    }

                    abort(404);
                }
            }
        }

        $link = Cache::remember(
            "link_slug:{$slug}",
            now()->addMinutes(10),
            fn () => DB::table('links')
                ->select(['id', 'original_url', 'status'])
                ->where('slug', $slug)
                ->first()
        );

        if (!$link || ($link->status ?? null) !== 'active') {
            abort(404);
        }

        $country = $this->getCountryCode($request);
        $domainSource = (string) $request->query('__src', $host);

        DB::table('clicks_log')->insert([
            'link_id' => $link->id,
            'domain_source' => $domainSource,
            'ip' => (string) $request->ip(),
            'user_agent' => $userAgent,
            'country' => $country,
            'referrer' => $request->header('referer'),
            'created_at' => now(),
        ]);

        return redirect()->away($link->original_url, 301);
    }

    private function isBlockedUserAgent(string $userAgent): bool
    {
        $ua = strtolower(trim($userAgent));

        if ($ua === '') {
            return true;
        }

        return (bool) preg_match('/bot|spider|crawler|curl|wget|scrapy|python|httpclient|headless/i', $ua);
    }

    private function getCountryCode(Request $request): ?string
    {
        $candidates = [
            $request->header('CF-IPCountry'),
            $request->header('CloudFront-Viewer-Country'),
            $request->header('X-Appengine-Country'),
            $request->header('X-Country-Code'),
        ];

        foreach ($candidates as $value) {
            if (!is_string($value)) {
                continue;
            }

            $value = strtoupper(trim($value));

            if (preg_match('/^[A-Z]{2}$/', $value) === 1) {
                return $value;
            }
        }

        return null;
    }
}
