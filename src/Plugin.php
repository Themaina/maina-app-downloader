<?php

namespace MainaSuperintelligence\AppDownloader;

use MainaSuperintelligence\AppDownloader\Supports\DownloadFiles;
use Botble\PluginManagement\Abstracts\PluginOperationAbstract;
use Botble\Setting\Models\Setting;
use Illuminate\Support\Facades\Schema;

class Plugin extends PluginOperationAbstract
{
    public static function remove(): void
    {
        DownloadFiles::deleteAll();
        Schema::dropIfExists('app_downloader_stats');

        Setting::query()
            ->where('key', 'like', 'app_downloader_%')
            ->delete();
    }
}
