<div class="ad-split">
    <div class="ad-split__copy">
        @include('plugins/app-downloader::themes.partials.head')
        @include('plugins/app-downloader::themes.partials.buttons')
    </div>

    <div class="ad-split__art" aria-hidden="true">
        <div class="ad-phone">
            @if (! empty($iconUrl))
                <img src="{{ $iconUrl }}" alt="" class="ad-phone__logo">
            @else
                <span class="ad-phone__logo">{{ mb_strtoupper(mb_substr(Maina888\AppDownloader\Supports\AppDownloader::appName() ?: trans('plugins/app-downloader::app-downloader.page_title'), 0, 1)) }}</span>
            @endif
            @if ($name = Maina888\AppDownloader\Supports\AppDownloader::appName())
                <span class="ad-phone__name">{{ $name }}</span>
            @endif
            <div class="ad-phone__bars"><span></span><span></span><span></span></div>
        </div>
    </div>
</div>
