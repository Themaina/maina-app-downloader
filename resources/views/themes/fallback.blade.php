@php
    use Maina888\AppDownloader\Supports\AppDownloader;

    $apple = '<path d="M16.37 12.64c-.02-2.2 1.8-3.26 1.88-3.31-1.02-1.5-2.62-1.7-3.19-1.73-1.36-.14-2.65.8-3.34.8-.69 0-1.75-.78-2.88-.76-1.48.02-2.85.86-3.61 2.19-1.54 2.67-.39 6.63 1.1 8.8.74 1.06 1.61 2.25 2.75 2.2 1.1-.04 1.52-.71 2.85-.71 1.33 0 1.71.71 2.88.69 1.19-.02 1.94-1.08 2.67-2.15.84-1.23 1.19-2.43 1.21-2.49-.03-.01-2.31-.89-2.33-3.53zM14.2 6.17c.61-.74 1.02-1.77.91-2.79-.88.04-1.94.59-2.57 1.32-.56.65-1.06 1.7-.93 2.7.98.08 1.98-.5 2.59-1.23z"/>';

    // [style, svg body]; "fill" icons are logos, "line" icons are generic glyphs.
    $icons = [
        'ios' => ['fill', $apple],
        'macos' => ['fill', $apple],
        'android' => ['fill', '<path d="M17.6 9.48l1.84-3.18a.38.38 0 0 0-.66-.38l-1.86 3.22A11.4 11.4 0 0 0 12 9.1c-1.7 0-3.3.38-4.92 1.04L5.22 6.92a.38.38 0 0 0-.66.38l1.84 3.18C3.27 12.2 1.3 15.1 1 18.5h22c-.3-3.4-2.27-6.3-5.4-8.02zM7 15.96a.96.96 0 1 1 0-1.92.96.96 0 0 1 0 1.92zm10 0a.96.96 0 1 1 0-1.92.96.96 0 0 1 0 1.92z"/>'],
        'windows' => ['fill', '<path d="M3 5.5l7.5-1v7H3v-6zm8.5-1.15L21 3v8.5h-9.5V4.35zM3 12.5h7.5v7L3 18.5v-6zm8.5 0H21V21l-9.5-1.35V12.5z"/>'],
        'huawei' => ['line', '<rect width="14" height="20" x="5" y="2" rx="2"/><path d="M12 18h.01"/>'],
        'amazon' => ['line', '<rect width="16" height="20" x="4" y="2" rx="2"/><path d="M12 18h.01"/>'],
        'microsoft' => ['line', '<path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/>'],
        'linux' => ['line', '<path d="m4 17 6-6-6-6"/><path d="M12 19h8"/>'],
    ];

    $links = array_intersect_key($links ?? [], AppDownloader::PLATFORMS);
    $sizes = $sizes ?? [];
    $recommended = ($recommended ?? null) && isset($links[$recommended]) ? $recommended : null;
    $others = array_diff_key($links, array_flip(array_filter([$recommended])));
    $design = in_array($design ?? null, AppDownloader::DESIGNS, true) ? $design : 'minimal';

    $label = fn (string $key) => trans("plugins/app-downloader::app-downloader.platforms.{$key}");
    $svg = fn (string $key) => '<svg viewBox="0 0 24 24" data-style="' . $icons[$key][0] . '" aria-hidden="true">' . $icons[$key][1] . '</svg>';
    $size = fn (string $key) => isset($sizes[$key]) ? ' <small class="app-downloader__size">' . e($sizes[$key]) . '</small>' : '';
    $button = fn (string $key, bool $primary = false) => '<a href="' . e($links[$key]) . '" rel="noopener" class="app-downloader__btn' . ($primary ? ' app-downloader__btn--primary' : '') . '">'
        . $svg($key)
        . '<span>' . e(trans('plugins/app-downloader::app-downloader.download_for', ['platform' => $label($key)])) . $size($key) . '</span>'
        . '</a>';
@endphp

@include('plugins/app-downloader::themes.partials.styles')

<section class="app-downloader app-downloader--{{ $design }}" @if (! empty($accent)) style="--ad-color: {{ $accent }}" @endif>
    @include("plugins/app-downloader::themes.designs.{$design}")
</section>
