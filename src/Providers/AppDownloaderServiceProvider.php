<?php

namespace Maina888\AppDownloader\Providers;

use Botble\Base\Facades\PanelSectionManager;
use Botble\Base\PanelSections\PanelSectionItem;
use Botble\Base\Supports\ServiceProvider;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Botble\Setting\PanelSections\SettingOthersPanelSection;

class AppDownloaderServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function boot(): void
    {
        $this
            ->setNamespace('plugins/app-downloader')
            ->loadRoutes()
            ->loadAndPublishConfigurations('permissions')
            ->loadAndPublishViews()
            ->loadAndPublishTranslations()
            ->loadMigrations();

        PanelSectionManager::beforeRendering(function (): void {
            PanelSectionManager::default()
                ->registerItem(
                    SettingOthersPanelSection::class,
                    fn () => PanelSectionItem::make('app-downloader')
                        ->setTitle(trans('plugins/app-downloader::app-downloader.settings.title'))
                        ->withIcon('ti ti-download')
                        ->withDescription(trans('plugins/app-downloader::app-downloader.settings.description'))
                        ->withPriority(999)
                        ->withRoute('app-downloader.settings')
                );
        });
    }
}
