<?php

namespace Maina888\AppDownloader\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class DeepLink implements ValidationRule
{
    /**
     * Accepts custom app schemes (myapp://open) and https universal links,
     * and rejects schemes that can run script or carry inline content.
     */
    public static function isValid(string $value): bool
    {
        if (! preg_match('/^([a-z][a-z0-9+.\-]*):(?:\/\/)?[^\s<>"\']+$/i', $value, $matches)) {
            return false;
        }

        return ! in_array(strtolower($matches[1]), ['javascript', 'data', 'vbscript', 'file', 'blob', 'about'], true);
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_string($value) || ! self::isValid($value)) {
            $fail('plugins/app-downloader::app-downloader.invalid_deep_link')->translate();
        }
    }
}
