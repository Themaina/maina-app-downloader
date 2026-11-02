<?php

namespace Maina888\AppDownloader\Http\Controllers;

use Maina888\AppDownloader\Supports\DownloadFiles;
use Botble\Base\Http\Controllers\BaseController;
use Symfony\Component\HttpFoundation\Response;

class FileController extends BaseController
{
    public function __invoke(string $platform): Response
    {
        $file = DownloadFiles::get($platform);

        abort_unless($file, 404);

        return response()->download(DownloadFiles::fullPath($file['path']), $file['name'], [
            'Content-Type' => 'application/octet-stream',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }
}
