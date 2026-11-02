<div class="ad-tiles">
    <div class="ad-tiles__head">
        @include('plugins/app-downloader::themes.partials.head')
    </div>

    @if (empty($links))
        <div class="app-downloader__empty" role="status">{{ trans('plugins/app-downloader::app-downloader.no_links_configured') }}</div>
    @else
        <div class="ad-tiles__grid">
            @foreach (array_replace(array_flip(array_filter([$recommended])), $links) as $key => $url)
                <a href="{{ $links[$key] }}" rel="noopener" class="ad-tile {{ $key === $recommended ? 'ad-tile--on' : '' }}">
                    @if ($key === $recommended)
                        <span class="ad-tile__chip">{{ trans('plugins/app-downloader::app-downloader.for_you') }}</span>
                    @endif
                    <span class="ad-tile__icon">{!! $svg($key) !!}</span>
                    <span class="ad-tile__name">{{ $label($key) }}</span>
                    <span class="ad-tile__cta">{{ trans('plugins/app-downloader::app-downloader.download') }}{!! $size($key) !!}</span>
                </a>
            @endforeach
        </div>
    @endif

    @if (! empty($deepLink))
        <a href="{{ $deepLink }}" class="app-downloader__open">{{ trans('plugins/app-downloader::app-downloader.open_app') }}</a>
    @endif
</div>
