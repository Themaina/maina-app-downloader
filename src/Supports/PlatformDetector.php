<?php

namespace Maina888\AppDownloader\Supports;

use Detection\MobileDetect;
use Throwable;

class PlatformDetector
{
    /**
     * Detect the visitor platform from a User-Agent string.
     *
     * Order matters: iOS first (iPadOS 13+ reports itself as "Macintosh"),
     * then the Android family (Huawei and Amazon devices also say "Android"),
     * then desktop systems. Anything unknown returns null so the chooser page
     * is shown instead of a wrong redirect.
     *
     * @return 'ios'|'android'|'huawei'|'amazon'|'windows'|'macos'|'linux'|null
     */
    public function detect(string $userAgent): ?string
    {
        $userAgent = trim($userAgent);

        if ($userAgent === '') {
            return null;
        }

        if (
            preg_match('/iPhone|iPad|iPod/i', $userAgent)
            || (preg_match('/Macintosh/i', $userAgent) && preg_match('/Mobile/i', $userAgent))
        ) {
            return 'ios';
        }

        if (preg_match('/Android|HarmonyOS/i', $userAgent)) {
            if (preg_match('/HUAWEI|HONOR|HarmonyOS|HMSCore|HuaweiBrowser/i', $userAgent)) {
                return 'huawei';
            }

            if (preg_match('/\bSilk\/|\bKF[A-Z]{2,}\b|\bAFT[A-Z]+\b|Kindle Fire/', $userAgent)) {
                return 'amazon';
            }

            return 'android';
        }

        if (preg_match('/Windows|Win32|Win64|WOW64/i', $userAgent)) {
            return 'windows';
        }

        if (preg_match('/Macintosh|Mac OS X/i', $userAgent)) {
            return 'macos';
        }

        if (preg_match('/Linux|X11/i', $userAgent) && ! preg_match('/CrOS/i', $userAgent)) {
            return 'linux';
        }

        return $this->detectViaMobileDetect($userAgent);
    }

    /**
     * Crawlers and link-preview fetchers always get the chooser page and are
     * left out of the statistics.
     */
    public function isBot(string $userAgent): bool
    {
        return (bool) preg_match(
            '/bot|crawl|spider|slurp|preview|facebookexternalhit|headless|lighthouse|monitor|curl|wget|python-requests/i',
            $userAgent
        );
    }

    /**
     * Last-resort check for exotic mobile user agents, using the library that
     * ships with Botble core. Never allowed to break the page.
     *
     * @return 'ios'|'android'|null
     */
    protected function detectViaMobileDetect(string $userAgent): ?string
    {
        if (! class_exists(MobileDetect::class)) {
            return null;
        }

        try {
            $detect = new MobileDetect();
            $detect->setUserAgent($userAgent);

            if ($detect->is('iOS')) {
                return 'ios';
            }

            if ($detect->is('AndroidOS')) {
                return 'android';
            }
        } catch (Throwable) {
            // Fall through to the chooser page.
        }

        return null;
    }
}
