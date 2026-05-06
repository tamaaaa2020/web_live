<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $totalClicks = (int) DB::table('clicks_log')->count();

        $since = now()->subDays(13)->startOfDay();

        $rows = DB::table('clicks_log')
            ->selectRaw('DATE(created_at) as day, COUNT(*) as clicks')
            ->where('created_at', '>=', $since)
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        $byDay = [];
        foreach ($rows as $row) {
            $byDay[(string) $row->day] = (int) $row->clicks;
        }

        $daily = [];
        for ($i = 0; $i < 14; $i++) {
            $day = $since->copy()->addDays($i)->toDateString();
            $daily[] = [
                'day' => $day,
                'clicks' => $byDay[$day] ?? 0,
            ];
        }

        $topLinks = DB::table('clicks_log')
            ->join('links', 'links.id', '=', 'clicks_log.link_id')
            ->selectRaw('links.id, links.slug, links.original_url, COUNT(*) as clicks')
            ->groupBy('links.id', 'links.slug', 'links.original_url')
            ->orderByDesc('clicks')
            ->limit(10)
            ->get();

        return view('admin.dashboard', [
            'totalClicks' => $totalClicks,
            'daily' => $daily,
            'topLinks' => $topLinks,
        ]);
    }
}

