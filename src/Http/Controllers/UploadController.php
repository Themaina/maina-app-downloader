<?php

namespace MainaSuperintelligence\AppDownloader\Http\Controllers;

use MainaSuperintelligence\AppDownloader\Supports\AppDownloader;
use MainaSuperintelligence\AppDownloader\Supports\DownloadFiles;
use Botble\Base\Http\Controllers\BaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * Receives installers in small chunks, so large files are not limited by
 * PHP's upload_max_filesize / post_max_size.
 */
class UploadController extends BaseController
{
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'platform' => ['required', 'string', 'in:' . implode(',', AppDownloader::uploadable())],
            'upload_id' => ['required', 'regex:/^[a-f0-9]{32}$/'],
            'name' => ['required', 'string', 'max:255'],
            'offset' => ['required', 'integer', 'min:0'],
            'total' => ['required', 'integer', 'min:1', 'max:' . DownloadFiles::MAX_BYTES],
            'chunk' => ['required', 'file'],
        ]);

        if (! DownloadFiles::accepts($data['platform'], $data['name'])) {
            return $this->fail(trans('plugins/app-downloader::app-downloader.upload.bad_type', [
                'types' => '.' . implode(', .', AppDownloader::PLATFORMS[$data['platform']]['extensions']),
            ]));
        }

        $disk = Storage::disk('local');
        $temp = DownloadFiles::tempPath($data['upload_id']);
        $offset = (int) $data['offset'];

        if ($offset === 0) {
            $disk->makeDirectory(dirname($temp));
            DownloadFiles::purgeStaleUploads();
            $disk->put($temp, '');
        }

        $partial = DownloadFiles::fullPath($temp);

        if (! is_file($partial) || filesize($partial) !== $offset) {
            return $this->fail(trans('plugins/app-downloader::app-downloader.upload.out_of_order'), 409);
        }

        $chunk = fopen($request->file('chunk')->getRealPath(), 'rb');
        $target = fopen($partial, 'ab');
        stream_copy_to_stream($chunk, $target);
        fclose($chunk);
        fclose($target);

        clearstatcache(true, $partial);
        $received = filesize($partial);

        if ($received > (int) $data['total']) {
            $disk->delete($temp);

            return $this->fail(trans('plugins/app-downloader::app-downloader.upload.failed'));
        }

        if ($received < (int) $data['total']) {
            return response()->json(['done' => false, 'received' => $received]);
        }

        $file = DownloadFiles::store($data['platform'], $temp, $data['name']);

        return response()->json(['done' => true, 'file' => DownloadFiles::describe($file)]);
    }

    public function destroy(string $platform): JsonResponse
    {
        abort_unless(in_array($platform, AppDownloader::uploadable(), true), 404);

        DownloadFiles::delete($platform);

        return response()->json(['done' => true]);
    }

    protected function fail(string $message, int $status = 422): JsonResponse
    {
        return response()->json(['message' => $message], $status);
    }
}
