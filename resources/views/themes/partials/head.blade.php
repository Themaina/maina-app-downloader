@if (! empty($iconUrl))
    <img src="{{ $iconUrl }}" alt="" class="app-downloader__icon" width="72" height="72">
@endif
<h1 class="app-downloader__title">{{ $title ?? trans('plugins/app-downloader::app-downloader.page_title') }}</h1>
<p class="app-downloader__text">{{ $description ?? trans('plugins/app-downloader::app-downloader.page_description') }}</p>
