<?php

namespace Maina888\AppDownloader\Http\Controllers;

use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Botble\Base\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class QrCodeController extends BaseController
{
    public function __invoke(Request $request): Response
    {
        abort_unless(class_exists(Writer::class), 404);

        $svg = (new Writer(new ImageRenderer(new RendererStyle(512, 2), new SvgImageBackEnd())))
            ->writeString(route('public.app-downloader'));

        $headers = ['Content-Type' => 'image/svg+xml'];

        if ($request->boolean('download')) {
            $headers['Content-Disposition'] = 'attachment; filename="download-qr.svg"';
        }

        return response($svg, 200, $headers);
    }
}
