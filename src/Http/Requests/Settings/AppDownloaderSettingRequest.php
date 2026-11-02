<?php

namespace MainaSuperintelligence\AppDownloader\Http\Requests\Settings;

use MainaSuperintelligence\AppDownloader\Rules\DeepLink;
use MainaSuperintelligence\AppDownloader\Supports\AppDownloader;
use Botble\Base\Rules\OnOffRule;
use Botble\Support\Http\Requests\Request;

class AppDownloaderSettingRequest extends Request
{
    protected function prepareForValidation(): void
    {
        $color = trim((string) $this->input('app_downloader_accent_color'));

        $this->merge([
            'app_downloader_accent_color' => $color === '' ? null : (AppDownloader::normalizeColor($color) ?? $color),
        ]);
    }

    public function rules(): array
    {
        $rules = [
            'app_downloader_enabled' => [new OnOffRule()],
            'app_downloader_track_stats' => [new OnOffRule()],
            'app_downloader_design' => ['nullable', 'string', 'in:' . implode(',', AppDownloader::DESIGNS)],
            'app_downloader_accent_color' => ['nullable', 'string', 'regex:/^#[0-9a-fA-F]{6}$/'],
            'app_downloader_app_name' => ['nullable', 'string', 'max:60'],
            'app_downloader_tagline' => ['nullable', 'string', 'max:140'],
            'app_downloader_icon' => ['nullable', 'string', 'max:255'],
            'app_downloader_deep_link' => ['nullable', 'string', 'max:2048', new DeepLink()],
        ];

        foreach (AppDownloader::platforms() as $platform) {
            // http(s) only: these URLs are used for redirects and href attributes.
            $rules[AppDownloader::settingKey($platform)] = ['nullable', 'string', 'url:http,https', 'max:2048'];
        }

        return $rules;
    }

    public function attributes(): array
    {
        $attributes = [
            'app_downloader_enabled' => trans('plugins/app-downloader::app-downloader.enabled'),
            'app_downloader_track_stats' => trans('plugins/app-downloader::app-downloader.track'),
            'app_downloader_design' => trans('plugins/app-downloader::app-downloader.design'),
            'app_downloader_accent_color' => trans('plugins/app-downloader::app-downloader.accent_color'),
            'app_downloader_app_name' => trans('plugins/app-downloader::app-downloader.app_name'),
            'app_downloader_tagline' => trans('plugins/app-downloader::app-downloader.tagline'),
            'app_downloader_icon' => trans('plugins/app-downloader::app-downloader.icon'),
            'app_downloader_deep_link' => trans('plugins/app-downloader::app-downloader.deep_link'),
        ];

        foreach (AppDownloader::platforms() as $platform) {
            $attributes[AppDownloader::settingKey($platform)] = trans('plugins/app-downloader::app-downloader.link_label', [
                'platform' => trans("plugins/app-downloader::app-downloader.platforms.{$platform}"),
            ]);
        }

        return $attributes;
    }
}
