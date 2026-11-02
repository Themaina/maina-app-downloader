@if (empty($links))
    <div class="app-downloader__empty" role="status">{{ trans('plugins/app-downloader::app-downloader.no_links_configured') }}</div>
@else
    @if ($recommended)
        {!! $button($recommended, true) !!}
    @endif

    @if ($others)
        @if ($recommended)
            <div class="app-downloader__label">{{ trans('plugins/app-downloader::app-downloader.other_platforms') }}</div>
        @endif
        <div class="app-downloader__list">
            @foreach ($others as $key => $url)
                {!! $button($key) !!}
            @endforeach
        </div>
    @endif
@endif

@if (! empty($deepLink))
    <a href="{{ $deepLink }}" class="app-downloader__open">{{ trans('plugins/app-downloader::app-downloader.open_app') }}</a>
@endif
