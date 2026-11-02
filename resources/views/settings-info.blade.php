@php
    use Maina888\AppDownloader\Supports\AppDownloader;

    $t = fn (string $key, array $replace = []) => trans("plugins/app-downloader::app-downloader.{$key}", $replace);
    $max = max(1, $stats['redirects'] ? max($stats['redirects']) : 1, $stats['chooser']);
@endphp

<div class="border rounded-3 p-3 p-md-4">
    <div class="row g-4 align-items-center">
        <div class="col">
            <div class="text-muted small mb-1">{{ $t('info.your_link') }}</div>
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <code class="fs-5 user-select-all" id="app-downloader-url">{{ $downloadUrl }}</code>
                <button type="button" class="btn btn-sm btn-outline-secondary" id="app-downloader-copy"
                        data-label="{{ $t('info.copy') }}" data-done="{{ $t('info.copied') }}">{{ $t('info.copy') }}</button>
                <a href="{{ $downloadUrl }}?preview=1" target="_blank" rel="noopener" class="btn btn-sm btn-outline-secondary">{{ $t('info.open') }}</a>
            </div>

            <div class="small mt-3">
                <span class="text-muted">{{ $t('info.test_as') }}</span>
                @forelse (array_keys($links) as $platform)
                    <a href="{{ $downloadUrl }}?platform={{ $platform }}&amp;preview=1" target="_blank" rel="noopener" class="me-2">{{ $t("platforms.{$platform}") }}</a>
                @empty
                    <em class="text-muted">{{ $t('info.no_links') }}</em>
                @endforelse
            </div>
            <div class="small mt-1">
                <span class="text-muted">{{ $t('info.preview_design') }}</span>
                @foreach (AppDownloader::DESIGNS as $design)
                    <a href="{{ $downloadUrl }}?chooser=1&amp;preview=1&amp;design={{ $design }}" target="_blank" rel="noopener" class="me-2">{{ $t("designs.{$design}") }}</a>
                @endforeach
            </div>
        </div>

        @if ($qrUrl)
            <div class="col-auto text-center">
                <img src="{{ $qrUrl }}" alt="QR" width="112" height="112" class="rounded border bg-white p-1">
                <div class="mt-1"><a href="{{ $qrUrl }}&amp;download=1" class="small">{{ $t('info.qr_download') }}</a></div>
            </div>
        @endif
    </div>

    <hr class="my-3">

    <div class="d-flex align-items-baseline gap-2 mb-2">
        <span class="fs-3 fw-semibold lh-1">{{ number_format($stats['total']) }}</span>
        <span class="text-muted small">{{ $t('info.stats_title') }}</span>
    </div>

    @if ($stats['total'] === 0)
        <div class="text-muted small">{{ $t('info.stats_empty') }}</div>
    @else
        @foreach ($stats['redirects'] + ['chooser' => $stats['chooser']] as $platform => $hits)
            @continue($hits === 0)
            <div class="d-flex align-items-center gap-2 small mb-1">
                <span class="text-truncate" style="width: 9rem;">{{ $platform === 'chooser' ? $t('info.stats_chooser') : ($t("platforms.{$platform}")) }}</span>
                <div class="progress flex-fill" style="height: .4rem;">
                    <div class="progress-bar {{ $platform === 'chooser' ? 'bg-secondary' : '' }}" style="width: {{ round($hits / $max * 100) }}%"></div>
                </div>
                <span class="text-muted" style="min-width: 3rem; text-align: end;">{{ number_format($hits) }}</span>
            </div>
        @endforeach
    @endif
</div>

<script>
    document.getElementById('app-downloader-copy')?.addEventListener('click', function () {
        const button = this;
        navigator.clipboard?.writeText(document.getElementById('app-downloader-url').textContent.trim()).then(function () {
            button.textContent = button.dataset.done;
            setTimeout(function () { button.textContent = button.dataset.label; }, 1500);
        });
    });
</script>
