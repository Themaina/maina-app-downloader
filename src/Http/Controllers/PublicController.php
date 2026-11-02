<?php

namespace MainaSuperintelligence\AppDownloader\Http\Controllers;

use MainaSuperintelligence\AppDownloader\Supports\AppDownloader;
use MainaSuperintelligence\AppDownloader\Supports\DownloadFiles;
use MainaSuperintelligence\AppDownloader\Supports\PlatformDetector;
use MainaSuperintelligence\AppDownloader\Supports\Stats;
use Botble\Base\Http\Controllers\BaseController;
use Botble\SeoHelper\Facades\SeoHelper;
use Botble\Theme\Facades\Theme;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PublicController extends BaseController
{
    public function index(Request $request, PlatformDetector $detector): Response
    {
        $links = AppDownloader::links();
        $userAgent = (string) $request->userAgent();
        $isBot = $detector->isBot($userAgent);

        // ?platform=<key> overrides detection (handy for QR codes and testing).
        $requested = strtolower((string) $request->query('platform'));
        $detected = match (true) {
            array_key_exists($requested, AppDownloader::PLATFORMS) => $requested,
            $isBot => null,
            default => $detector->detect($userAgent),
        };

        $target = AppDownloader::resolve($detected, $links);

        // ?chooser=1 skips the redirect; crawlers always get the chooser page.
        $redirect = $target
            && AppDownloader::isEnabled()
            && ! $isBot
            && ! $request->boolean('chooser');

        $track = AppDownloader::isTrackingEnabled() && ! $isBot && ! $request->boolean('preview');

        if ($redirect) {
            $track && Stats::record($target, 'redirect');

            return $this->withDynamicHeaders(redirect()->away($links[$target]));
        }

        $track && Stats::record($detected ?? 'other', 'chooser');

        $title = AppDownloader::pageTitle();
        $description = AppDownloader::pageDescription();

        SeoHelper::setTitle($title)->setDescription($description);

        Theme::breadcrumb()->add($title, route('public.app-downloader'));

        // ?design=<name> previews a design without saving it.
        $design = in_array($request->query('design'), AppDownloader::DESIGNS, true)
            ? $request->query('design')
            : AppDownloader::design();

        $sizes = [];

        foreach (AppDownloader::uploadable() as $platform) {
            if ($file = DownloadFiles::get($platform)) {
                $sizes[$platform] = DownloadFiles::humanSize($file['size']);
            }
        }

        $response = Theme::scope(
            'download',
            [
                'links' => $links,
                'detected' => $detected,
                'recommended' => $target,
                'title' => $title,
                'description' => $description,
                'iconUrl' => AppDownloader::iconUrl(),
                'deepLink' => AppDownloader::deepLink(),
                'design' => $design,
                'accent' => AppDownloader::accentColor(),
                'sizes' => $sizes,
            ],
            'plugins/app-downloader::themes.fallback'
        )->render();

        return $this->withDynamicHeaders($response);
    }

    /**
     * The response depends on the User-Agent, so keep CDNs and browsers from
     * serving one visitor's redirect to another.
     */
    protected function withDynamicHeaders(Response $response): Response
    {
        $response->headers->set('Cache-Control', 'no-store, private');
        $response->headers->set('Vary', 'User-Agent');

        return $response;
    }
}
