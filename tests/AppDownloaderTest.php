<?php

namespace Maina888\AppDownloader\Tests;

use Maina888\AppDownloader\Supports\AppDownloader;
use PHPUnit\Framework\TestCase;

class AppDownloaderTest extends TestCase
{
    public function test_it_uses_the_platform_link_when_present(): void
    {
        $this->assertSame('ios', AppDownloader::resolve('ios', ['ios' => 'https://a.test', 'android' => 'https://b.test']));
    }

    public function test_it_returns_null_without_a_link_or_platform(): void
    {
        $this->assertNull(AppDownloader::resolve('ios', ['android' => 'https://b.test']));
        $this->assertNull(AppDownloader::resolve('linux', []));
        $this->assertNull(AppDownloader::resolve(null, ['ios' => 'https://a.test']));
    }

    public function test_huawei_and_amazon_fall_back_to_android(): void
    {
        $links = ['android' => 'https://play.test'];

        $this->assertSame('android', AppDownloader::resolve('huawei', $links));
        $this->assertSame('android', AppDownloader::resolve('amazon', $links));
        $this->assertSame('huawei', AppDownloader::resolve('huawei', $links + ['huawei' => 'https://hw.test']));
    }

    public function test_windows_falls_back_to_the_microsoft_store(): void
    {
        $this->assertSame('microsoft', AppDownloader::resolve('windows', ['microsoft' => 'https://ms.test']));
        $this->assertSame('windows', AppDownloader::resolve('windows', ['windows' => 'https://a.test', 'microsoft' => 'https://ms.test']));
    }

    public function test_platforms_can_be_filtered_by_group(): void
    {
        $this->assertSame(['ios', 'android', 'huawei', 'amazon'], AppDownloader::platforms('mobile'));
        $this->assertSame(['windows', 'microsoft', 'macos', 'linux'], AppDownloader::platforms('desktop'));
        $this->assertCount(8, AppDownloader::platforms());
    }

    public function test_it_normalises_colours_from_a_picker(): void
    {
        $this->assertSame('#ff9900', AppDownloader::normalizeColor('#ff9900'));
        $this->assertSame('#ff9900', AppDownloader::normalizeColor('#FF990080'));
        $this->assertSame('#ffaa00', AppDownloader::normalizeColor('#fa0'));
        $this->assertSame('#ff9900', AppDownloader::normalizeColor('rgb(255, 153, 0)'));
        $this->assertSame('#ff9900', AppDownloader::normalizeColor('rgba(255,153,0,0.5)'));
        $this->assertNull(AppDownloader::normalizeColor('orange'));
        $this->assertNull(AppDownloader::normalizeColor('red; background:url(x)'));
        $this->assertNull(AppDownloader::normalizeColor(''));
    }
}
