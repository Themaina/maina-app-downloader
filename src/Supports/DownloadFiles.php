<?php

namespace Maina888\AppDownloader\Supports;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;

/**
 * Installer files uploaded from the admin panel. They live on the private
 * "local" disk and are only ever served through the plugin's download route.
 */
class DownloadFiles
{
    public const DIRECTORY = 'app-downloader';

    public const MAX_BYTES = 2 * 1024 * 1024 * 1024;

    protected static function settingKey(string $platform): string
    {
        return "app_downloader_{$platform}_file";
    }

    protected static function disk(): Filesystem
    {
        return Storage::disk('local');
    }

    /**
     * @return array{path: string, name: string, size: int}|null
     */
    public static function get(string $platform): ?array
    {
        $raw = (string) setting(self::settingKey($platform), '');

        if ($raw === '') {
            return null;
        }

        $file = json_decode($raw, true);

        if (! is_array($file) || empty($file['path']) || empty($file['name']) || ! self::disk()->exists($file['path'])) {
            return null;
        }

        return ['path' => $file['path'], 'name' => $file['name'], 'size' => (int) ($file['size'] ?? 0)];
    }

    /**
     * @param array{name: string, size: int} $file
     */
    public static function describe(array $file): array
    {
        return ['name' => $file['name'], 'size' => $file['size'], 'human' => self::humanSize($file['size'])];
    }

    public static function humanSize(int $bytes): string
    {
        foreach (['B', 'KB', 'MB', 'GB'] as $i => $unit) {
            if ($bytes < 1024 ** ($i + 1) || $unit === 'GB') {
                return round($bytes / 1024 ** $i, $i > 1 ? 1 : 0) . ' ' . $unit;
            }
        }

        return $bytes . ' B';
    }

    public static function url(string $platform): string
    {
        return route('public.app-downloader.file', $platform);
    }

    public static function fullPath(string $path): string
    {
        return self::disk()->path($path);
    }

    public static function tempPath(string $uploadId): string
    {
        return self::DIRECTORY . "/tmp/{$uploadId}.part";
    }

    public static function accepts(string $platform, string $filename): bool
    {
        $extensions = AppDownloader::PLATFORMS[$platform]['extensions'] ?? [];

        return in_array(strtolower(pathinfo($filename, PATHINFO_EXTENSION)), $extensions, true);
    }

    public static function sanitizeName(string $filename): string
    {
        $name = preg_replace('/[^A-Za-z0-9._-]+/', '-', basename(str_replace('\\', '/', $filename)));

        return trim((string) $name, '.-') ?: 'download';
    }

    /**
     * Move a finished upload into place, replacing the previous file.
     *
     * @return array{path: string, name: string, size: int}
     */
    public static function store(string $platform, string $tempPath, string $originalName): array
    {
        self::delete($platform);

        $name = self::sanitizeName($originalName);
        $path = self::DIRECTORY . "/{$platform}/" . bin2hex(random_bytes(6)) . "-{$name}";

        self::disk()->makeDirectory(dirname($path));
        self::disk()->move($tempPath, $path);

        $file = ['path' => $path, 'name' => $name, 'size' => (int) self::disk()->size($path)];

        setting()->set(self::settingKey($platform), json_encode($file))->save();

        return $file;
    }

    public static function delete(string $platform): void
    {
        $raw = json_decode((string) setting(self::settingKey($platform), ''), true);

        if (is_array($raw) && ! empty($raw['path'])) {
            self::disk()->delete($raw['path']);
        }

        setting()->set(self::settingKey($platform), '')->save();
    }

    public static function purgeStaleUploads(): void
    {
        foreach (self::disk()->files(self::DIRECTORY . '/tmp') as $file) {
            if (self::disk()->lastModified($file) < time() - 86400) {
                self::disk()->delete($file);
            }
        }
    }

    public static function deleteAll(): void
    {
        self::disk()->deleteDirectory(self::DIRECTORY);
    }
}
