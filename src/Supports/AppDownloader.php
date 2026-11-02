<?php

namespace MainaSuperintelligence\AppDownloader\Supports;

use Botble\Media\Facades\RvMedia;

class AppDownloader
{
    /**
     * Supported platforms, in the order they are shown.
     */
    public const PLATFORMS = [
        'ios' => ['group' => 'mobile', 'placeholder' => 'https://apps.apple.com/app/id1234567890'],
        'android' => ['group' => 'mobile', 'placeholder' => 'https://play.google.com/store/apps/details?id=com.example.app', 'extensions' => ['apk']],
        'huawei' => ['group' => 'mobile', 'placeholder' => 'https://appgallery.huawei.com/app/C123456789', 'extensions' => ['apk']],
        'amazon' => ['group' => 'mobile', 'placeholder' => 'https://www.amazon.com/dp/B0123456789', 'extensions' => ['apk']],
        'windows' => ['group' => 'desktop', 'placeholder' => 'https://example.com/downloads/app-setup.exe', 'extensions' => ['exe', 'msi', 'msix', 'appx', 'zip']],
        'microsoft' => ['group' => 'desktop', 'placeholder' => 'https://apps.microsoft.com/detail/9ABCDEF12345'],
        'macos' => ['group' => 'desktop', 'placeholder' => 'https://example.com/downloads/app.dmg', 'extensions' => ['dmg', 'pkg', 'zip']],
        'linux' => ['group' => 'desktop', 'placeholder' => 'https://example.com/downloads/app.AppImage', 'extensions' => ['appimage', 'deb', 'rpm', 'gz', 'zip']],
    ];

    public const DESIGNS = ['minimal', 'hero', 'split', 'tiles'];

    /**
     * Which links a detected platform may use, in order of preference.
     * Platforms not listed only use their own link.
     */
    public const FALLBACKS = [
        'huawei' => ['huawei', 'android'],
        'amazon' => ['amazon', 'android'],
        'windows' => ['windows', 'microsoft'],
    ];

    /**
     * @return array<int, string>
     */
    public static function platforms(?string $group = null): array
    {
        return array_keys(
            $group ? array_filter(self::PLATFORMS, fn (array $platform) => $platform['group'] === $group) : self::PLATFORMS
        );
    }

    /**
     * Platforms that accept an uploaded installer instead of a link.
     *
     * @return array<int, string>
     */
    public static function uploadable(): array
    {
        return array_keys(array_filter(self::PLATFORMS, fn (array $platform) => ! empty($platform['extensions'])));
    }

    public static function settingKey(string $platform): string
    {
        return "app_downloader_{$platform}_url";
    }

    /**
     * Pick the platform whose link should be used for a detected platform.
     *
     * @param array<string, string> $links
     */
    public static function resolve(?string $detected, array $links): ?string
    {
        if (! $detected) {
            return null;
        }

        foreach (self::FALLBACKS[$detected] ?? [$detected] as $platform) {
            if (! empty($links[$platform])) {
                return $platform;
            }
        }

        return null;
    }

    public static function isEnabled(): bool
    {
        return (bool) setting('app_downloader_enabled', true);
    }

    public static function isTrackingEnabled(): bool
    {
        return (bool) setting('app_downloader_track_stats', true);
    }

    /**
     * Configured download URLs keyed by platform; blank values are omitted.
     *
     * @return array<string, string>
     */
    public static function links(): array
    {
        $links = [];

        foreach (self::platforms() as $platform) {
            // An uploaded installer wins over a typed link.
            $url = DownloadFiles::get($platform)
                ? DownloadFiles::url($platform)
                : trim((string) setting(self::settingKey($platform), ''));

            if ($url !== '') {
                $links[$platform] = $url;
            }
        }

        return $links;
    }

    public static function design(): string
    {
        $design = (string) setting('app_downloader_design', 'minimal');

        return in_array($design, self::DESIGNS, true) ? $design : 'minimal';
    }

    /**
     * Optional accent colour (#rrggbb). Null means "use the theme's colour".
     */
    public static function accentColor(): ?string
    {
        return self::normalizeColor((string) setting('app_downloader_accent_color', ''));
    }

    /**
     * Turn whatever a colour picker sends (#abc, #aabbcc, #aabbccdd, rgb(), rgba())
     * into #rrggbb. Returns null when the value is not a colour.
     */
    public static function normalizeColor(?string $value): ?string
    {
        $value = strtolower(trim((string) $value));

        if (preg_match('/^#([0-9a-f]{3})$/', $value, $m)) {
            return '#' . preg_replace('/(.)/', '$1$1', $m[1]);
        }

        if (preg_match('/^#([0-9a-f]{6})(?:[0-9a-f]{2})?$/', $value, $m)) {
            return '#' . $m[1];
        }

        if (preg_match('/^rgba?\(\s*(\d{1,3})\s*[, ]\s*(\d{1,3})\s*[, ]\s*(\d{1,3})\s*(?:[,\/]\s*[\d.%]+\s*)?\)$/', $value, $m)) {
            return sprintf('#%02x%02x%02x', min(255, (int) $m[1]), min(255, (int) $m[2]), min(255, (int) $m[3]));
        }

        return null;
    }

    public static function appName(): string
    {
        return trim((string) setting('app_downloader_app_name', ''));
    }

    public static function tagline(): string
    {
        return trim((string) setting('app_downloader_tagline', ''));
    }

    public static function deepLink(): string
    {
        return trim((string) setting('app_downloader_deep_link', ''));
    }

    public static function iconUrl(): ?string
    {
        $icon = trim((string) setting('app_downloader_icon', ''));

        return $icon !== '' ? RvMedia::getImageUrl($icon, 'thumb') : null;
    }

    public static function pageTitle(): string
    {
        $name = self::appName();

        return $name !== ''
            ? trans('plugins/app-downloader::app-downloader.get_app', ['name' => $name])
            : trans('plugins/app-downloader::app-downloader.page_title');
    }

    public static function pageDescription(): string
    {
        return self::tagline() ?: trans('plugins/app-downloader::app-downloader.page_description');
    }
}
