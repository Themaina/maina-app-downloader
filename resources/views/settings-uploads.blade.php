@php
    $t = fn (string $key, array $replace = []) => trans("plugins/app-downloader::app-downloader.{$key}", $replace);
@endphp

<div id="app-downloader-uploads" class="border rounded-3"
     data-url="{{ route('app-downloader.files.store') }}"
     data-delete-url="{{ route('app-downloader.files.destroy', '__platform__') }}"
     data-token="{{ csrf_token() }}"
     data-chunk="{{ $chunkSize }}"
     data-max="{{ $maxBytes }}"
     data-too-big="{{ $t('upload.too_big') }}"
     data-failed="{{ $t('upload.failed') }}"
     data-replace="{{ $t('upload.replace') }}"
     data-confirm="{{ $t('upload.confirm_remove') }}">
    @foreach ($rows as $row)
        <div class="d-flex align-items-center gap-3 px-3 py-2 {{ ! $loop->first ? 'border-top' : '' }}" data-platform="{{ $row['platform'] }}">
            <div class="fw-medium" style="width: 9rem;">{{ $row['label'] }}</div>

            <div class="flex-fill small text-truncate" data-role="status">
                @if ($row['file'])
                    <span class="text-body">{{ $row['file']['name'] }}</span>
                    <span class="text-muted">· {{ $row['file']['human'] }}</span>
                @else
                    <span class="text-muted">{{ $t('upload.none', ['types' => $row['accept']]) }}</span>
                @endif
            </div>

            <div class="progress d-none" style="width: 7rem; height: .35rem;" data-role="progress">
                <div class="progress-bar" style="width: 0%"></div>
            </div>

            <button type="button" class="btn btn-sm btn-outline-danger {{ $row['file'] ? '' : 'd-none' }}" data-role="remove">{{ $t('upload.remove') }}</button>
            <label class="btn btn-sm btn-outline-secondary mb-0" data-role="choose">
                <span data-role="choose-label">{{ $row['file'] ? $t('upload.replace') : $t('upload.choose') }}</span>
                <input type="file" class="d-none" accept="{{ $row['accept'] }}">
            </label>
        </div>
    @endforeach
</div>

<script>
    (function () {
        const root = document.getElementById('app-downloader-uploads');
        if (!root) return;

        const text = (row, role) => row.querySelector(`[data-role="${role}"]`);
        const human = (bytes) => {
            const units = ['B', 'KB', 'MB', 'GB'];
            let i = 0;
            while (bytes >= 1024 && i < units.length - 1) { bytes /= 1024; i++; }
            return `${i > 1 ? bytes.toFixed(1) : Math.round(bytes)} ${units[i]}`;
        };
        const setStatus = (row, name, size, isError) => {
            const status = text(row, 'status');
            status.textContent = '';
            const label = document.createElement('span');
            label.className = isError ? 'text-danger' : 'text-body';
            label.textContent = name;
            status.append(label);
            if (size) {
                const extra = document.createElement('span');
                extra.className = 'text-muted';
                extra.textContent = ` · ${size}`;
                status.append(extra);
            }
        };
        const request = async (url, options) => {
            const response = await fetch(url, {
                ...options,
                headers: {'X-CSRF-TOKEN': root.dataset.token, 'Accept': 'application/json', ...(options.headers || {})},
            });
            const data = await response.json().catch(() => ({}));
            if (!response.ok) throw new Error(data.message || root.dataset.failed);
            return data;
        };

        root.querySelectorAll('[data-platform]').forEach((row) => {
            const input = row.querySelector('input[type=file]');
            const bar = text(row, 'progress');
            const remove = text(row, 'remove');
            const choose = text(row, 'choose');

            input.addEventListener('change', async () => {
                const file = input.files[0];
                input.value = '';
                if (!file) return;
                if (file.size > Number(root.dataset.max)) { setStatus(row, root.dataset.tooBig, null, true); return; }

                const id = Array.from(crypto.getRandomValues(new Uint8Array(16)), (b) => b.toString(16).padStart(2, '0')).join('');
                const chunk = Number(root.dataset.chunk);
                bar.classList.remove('d-none');
                choose.classList.add('disabled');
                remove.classList.add('d-none');

                try {
                    let offset = 0, result;
                    while (offset < file.size) {
                        const body = new FormData();
                        body.append('platform', row.dataset.platform);
                        body.append('upload_id', id);
                        body.append('name', file.name);
                        body.append('offset', offset);
                        body.append('total', file.size);
                        body.append('chunk', file.slice(offset, offset + chunk), 'chunk');
                        result = await request(root.dataset.url, {method: 'POST', body});
                        offset = Math.min(offset + chunk, file.size);
                        bar.firstElementChild.style.width = `${Math.round(offset / file.size * 100)}%`;
                    }
                    setStatus(row, result.file.name, result.file.human, false);
                    text(row, 'choose-label').textContent = root.dataset.replace;
                    remove.classList.remove('d-none');
                } catch (error) {
                    setStatus(row, error.message, null, true);
                } finally {
                    bar.classList.add('d-none');
                    bar.firstElementChild.style.width = '0%';
                    choose.classList.remove('disabled');
                }
            });

            remove.addEventListener('click', async () => {
                if (!confirm(root.dataset.confirm)) return;
                try {
                    await request(root.dataset.deleteUrl.replace('__platform__', row.dataset.platform), {method: 'DELETE'});
                    location.reload();
                } catch (error) {
                    setStatus(row, error.message, null, true);
                }
            });
        });
    })();
</script>
