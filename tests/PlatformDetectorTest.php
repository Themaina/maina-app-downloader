<?php

namespace Maina888\AppDownloader\Tests;

use Maina888\AppDownloader\Supports\PlatformDetector;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class PlatformDetectorTest extends TestCase
{
    public static function userAgents(): array
    {
        return [
            'iPhone' => ['Mozilla/5.0 (iPhone; CPU iPhone OS 17_0 like Mac OS X) AppleWebKit/605.1.15 Mobile/15E148 Safari/604.1', 'ios'],
            'iPad' => ['Mozilla/5.0 (iPad; CPU OS 17_0 like Mac OS X) AppleWebKit/605.1.15 Mobile/15E148 Safari/604.1', 'ios'],
            'iPadOS in desktop mode' => ['Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 Version/17.0 Mobile/15E148 Safari/604.1', 'ios'],
            'Pixel' => ['Mozilla/5.0 (Linux; Android 14; Pixel 8) AppleWebKit/537.36 Chrome/120 Mobile Safari/537.36', 'android'],
            'Huawei' => ['Mozilla/5.0 (Linux; Android 12; HUAWEI P50) AppleWebKit/537.36 HuaweiBrowser/13.0 Mobile Safari/537.36', 'huawei'],
            'Honor' => ['Mozilla/5.0 (Linux; Android 13; HONOR 90) AppleWebKit/537.36 Chrome/120 Mobile Safari/537.36', 'huawei'],
            'Fire tablet' => ['Mozilla/5.0 (Linux; Android 9; KFMAWI) AppleWebKit/537.36 Silk/120.4 like Chrome/120 Safari/537.36', 'amazon'],
            'Windows' => ['Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 Chrome/120 Safari/537.36', 'windows'],
            'macOS' => ['Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 Version/17.0 Safari/605.1.15', 'macos'],
            'Linux' => ['Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 Chrome/120 Safari/537.36', 'linux'],
            'ChromeOS' => ['Mozilla/5.0 (X11; CrOS x86_64 14541.0.0) AppleWebKit/537.36 Chrome/120 Safari/537.36', null],
            'empty' => ['', null],
            'unknown' => ['SomeCustomClient/1.0', null],
        ];
    }

    #[DataProvider('userAgents')]
    public function test_it_detects_the_platform(string $userAgent, ?string $expected): void
    {
        $this->assertSame($expected, (new PlatformDetector())->detect($userAgent));
    }

    public function test_it_recognises_crawlers(): void
    {
        $detector = new PlatformDetector();

        $this->assertTrue($detector->isBot('Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X) Mobile Safari/537.36 (compatible; Googlebot/2.1)'));
        $this->assertTrue($detector->isBot('facebookexternalhit/1.1'));
        $this->assertFalse($detector->isBot('Mozilla/5.0 (iPhone; CPU iPhone OS 17_0 like Mac OS X) Mobile/15E148 Safari/604.1'));
    }
}
