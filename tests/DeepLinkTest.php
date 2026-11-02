<?php

namespace Maina888\AppDownloader\Tests;

use Maina888\AppDownloader\Rules\DeepLink;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class DeepLinkTest extends TestCase
{
    public static function links(): array
    {
        return [
            ['myapp://open', true],
            ['acme:open', true],
            ['https://example.com/app', true],
            ['javascript:alert(1)', false],
            ['JaVaScRiPt:alert(1)', false],
            ['data:text/html,hello', false],
            ['file:///etc/passwd', false],
            ['myapp://has space', false],
            ['not a link', false],
        ];
    }

    #[DataProvider('links')]
    public function test_it_validates_app_links(string $value, bool $valid): void
    {
        $this->assertSame($valid, DeepLink::isValid($value));
    }
}
