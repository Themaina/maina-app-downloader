<?php

namespace MainaSuperintelligence\AppDownloader\Supports;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Throwable;

class Stats
{
    public const TABLE = 'app_downloader_stats';

    /**
     * Count one visit. Only a date, a platform and a counter are stored: no
     * IP address, User-Agent or any other personal data.
     *
     * Tracking must never break the download page, so failures are swallowed.
     */
    public static function record(string $platform, string $outcome): void
    {
        try {
            $key = ['date' => Carbon::today()->toDateString(), 'platform' => $platform, 'outcome' => $outcome];

            DB::table(self::TABLE)->insertOrIgnore($key + ['hits' => 0]);
            DB::table(self::TABLE)->where($key)->increment('hits');
        } catch (Throwable) {
            // The table may be missing if the plugin was not migrated yet.
        }
    }

    /**
     * @return array{total: int, redirects: array<string, int>, chooser: int}
     */
    public static function summary(int $days = 30): array
    {
        $summary = ['total' => 0, 'redirects' => [], 'chooser' => 0];

        try {
            $rows = DB::table(self::TABLE)
                ->where('date', '>=', Carbon::today()->subDays($days - 1)->toDateString())
                ->selectRaw('platform, outcome, SUM(hits) as hits')
                ->groupBy('platform', 'outcome')
                ->get();
        } catch (Throwable) {
            return $summary;
        }

        foreach ($rows as $row) {
            $hits = (int) $row->hits;
            $summary['total'] += $hits;

            if ($row->outcome === 'redirect') {
                $summary['redirects'][$row->platform] = $hits;
            } else {
                $summary['chooser'] += $hits;
            }
        }

        arsort($summary['redirects']);

        return $summary;
    }
}
