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

        DB::table('clicks_log')->insert([
            'link_id' => $link->id,
            'domain_source' => (string) $request->getHost(),
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

