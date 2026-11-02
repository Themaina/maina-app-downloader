<?php

namespace Maina888\AppDownloader\Forms\Settings;

use BaconQrCode\Writer;
use Maina888\AppDownloader\Http\Requests\Settings\AppDownloaderSettingRequest;
use Maina888\AppDownloader\Supports\AppDownloader;
use Maina888\AppDownloader\Supports\DownloadFiles;
use Maina888\AppDownloader\Supports\Stats;
use Botble\Base\Forms\FieldOptions\ColorFieldOption;
use Botble\Base\Forms\FieldOptions\HtmlFieldOption;
use Botble\Base\Forms\FieldOptions\MediaImageFieldOption;
use Botble\Base\Forms\FieldOptions\OnOffFieldOption;
use Botble\Base\Forms\FieldOptions\SelectFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\Fields\ColorField;
use Botble\Base\Forms\Fields\HtmlField;
use Botble\Base\Forms\Fields\MediaImageField;
use Botble\Base\Forms\Fields\OnOffCheckboxField;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Setting\Forms\SettingForm;
use Illuminate\Http\UploadedFile;

class AppDownloaderSettingForm extends SettingForm
{
    public function setup(): void
    {
        parent::setup();

        $this
            ->setSectionTitle(trans('plugins/app-downloader::app-downloader.settings.title'))
            ->setSectionDescription(trans('plugins/app-downloader::app-downloader.settings.description'))
            ->setValidatorClass(AppDownloaderSettingRequest::class)
            ->add(
                'app_downloader_info',
                HtmlField::class,
                HtmlFieldOption::make()->view('plugins/app-downloader::settings-info', [
                    'downloadUrl' => route('public.app-downloader'),
                    'qrUrl' => class_exists(Writer::class) ? route('app-downloader.qr') : null,
                    'links' => AppDownloader::links(),
                    'stats' => Stats::summary(),
                ])
            )
            ->addSection('options')
            ->add(
                'app_downloader_enabled',
                OnOffCheckboxField::class,
                OnOffFieldOption::make()
                    ->defaultValue(AppDownloader::isEnabled())
                    ->label(trans('plugins/app-downloader::app-downloader.enabled'))
            )
            ->add(
                'app_downloader_track_stats',
                OnOffCheckboxField::class,
                OnOffFieldOption::make()
                    ->defaultValue(AppDownloader::isTrackingEnabled())
                    ->label(trans('plugins/app-downloader::app-downloader.track'))
            )
            ->addSection('links_mobile')
            ->addPlatformFields('mobile')
            ->addSection('links_desktop')
            ->addPlatformFields('desktop')
            ->addSection('files')
            ->add(
                'app_downloader_files',
                HtmlField::class,
                HtmlFieldOption::make()->view('plugins/app-downloader::settings-uploads', [
                    'rows' => $this->uploadRows(),
                    'chunkSize' => $this->chunkSize(),
                    'maxBytes' => DownloadFiles::MAX_BYTES,
                ])
            )
            ->addSection('branding')
            ->add(
                'app_downloader_design',
                SelectField::class,
                SelectFieldOption::make()
                    ->label(trans('plugins/app-downloader::app-downloader.design'))
                    ->choices(collect(AppDownloader::DESIGNS)->mapWithKeys(
                        fn (string $design) => [$design => trans("plugins/app-downloader::app-downloader.designs.{$design}")]
                    )->all())
                    ->selected(AppDownloader::design())
            )
            ->add(
                'app_downloader_accent_color',
                ColorField::class,
                ColorFieldOption::make()
                    ->label(trans('plugins/app-downloader::app-downloader.accent_color'))
                    ->value(AppDownloader::accentColor())
            )
            ->add(
                'app_downloader_app_name',
                TextField::class,
                TextFieldOption::make()
                    ->value(setting('app_downloader_app_name'))
                    ->label(trans('plugins/app-downloader::app-downloader.app_name'))
                    ->placeholder('Acme')
                    ->maxLength(60)
            )
            ->add(
                'app_downloader_tagline',
                TextField::class,
                TextFieldOption::make()
                    ->value(setting('app_downloader_tagline'))
                    ->label(trans('plugins/app-downloader::app-downloader.tagline'))
                    ->placeholder(trans('plugins/app-downloader::app-downloader.page_description'))
                    ->maxLength(140)
            )
            ->add(
                'app_downloader_icon',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->value(setting('app_downloader_icon'))
                    ->label(trans('plugins/app-downloader::app-downloader.icon'))
            )
            ->add(
                'app_downloader_deep_link',
                TextField::class,
                TextFieldOption::make()
                    ->value(setting('app_downloader_deep_link'))
                    ->label(trans('plugins/app-downloader::app-downloader.deep_link'))
                    ->placeholder('myapp://open')
                    ->maxLength(2048)
            );
    }

    protected function addSection(string $section): static
    {
        return $this->add(
            "app_downloader_section_{$section}",
            HtmlField::class,
            HtmlFieldOption::make()->content(
                '<div class="mt-4 mb-1 fw-semibold text-uppercase text-muted small">'
                . e(trans("plugins/app-downloader::app-downloader.sections.{$section}"))
                . '</div>'
            )
        );
    }

    protected function addPlatformFields(string $group): static
    {
        foreach (AppDownloader::platforms($group) as $platform) {
            $key = AppDownloader::settingKey($platform);

            $this->add(
                $key,
                TextField::class,
                TextFieldOption::make()
                    ->value(setting($key))
                    ->label(trans('plugins/app-downloader::app-downloader.link_label', [
                        'platform' => trans("plugins/app-downloader::app-downloader.platforms.{$platform}"),
                    ]))
                    ->placeholder(AppDownloader::PLATFORMS[$platform]['placeholder'])
                    ->maxLength(2048)
            );
        }

        return $this;
    }

    /**
     * @return array<int, array{platform: string, label: string, accept: string, file: array|null}>
     */
    protected function uploadRows(): array
    {
        return collect(AppDownloader::uploadable())->map(function (string $platform): array {
            $file = DownloadFiles::get($platform);

            return [
                'platform' => $platform,
                'label' => trans("plugins/app-downloader::app-downloader.platforms.{$platform}"),
                'accept' => '.' . implode(',.', AppDownloader::PLATFORMS[$platform]['extensions']),
                'file' => $file ? DownloadFiles::describe($file) : null,
            ];
        })->all();
    }

    /**
     * Largest chunk the server accepts per request, capped at 8 MB.
     */
    protected function chunkSize(): int
    {
        return (int) max(256 * 1024, min(8 * 1024 * 1024, UploadedFile::getMaxFilesize() * 0.9));
    }
}
