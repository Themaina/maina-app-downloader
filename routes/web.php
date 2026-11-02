<?php

use MainaSuperintelligence\AppDownloader\Http\Controllers\FileController;
use MainaSuperintelligence\AppDownloader\Http\Controllers\PublicController;
use MainaSuperintelligence\AppDownloader\Http\Controllers\QrCodeController;
use MainaSuperintelligence\AppDownloader\Http\Controllers\Settings\AppDownloaderSettingController;
use MainaSuperintelligence\AppDownloader\Http\Controllers\UploadController;
use Botble\Base\Facades\AdminHelper;
use Botble\Theme\Facades\Theme;
use Illuminate\Support\Facades\Route;

Theme::registerRoutes(function (): void {
    Route::get('download', [PublicController::class, 'index'])
        ->name('public.app-downloader');

    Route::get('download/file/{platform}', FileController::class)
        ->where('platform', '[a-z]+')
        ->name('public.app-downloader.file');
});

AdminHelper::registerRoutes(function (): void {
    Route::prefix('app-downloader')
        ->name('app-downloader.')
        ->group(function (): void {
            Route::group(['prefix' => 'settings', 'permission' => 'app-downloader.settings'], function (): void {
                Route::get('/', [AppDownloaderSettingController::class, 'edit'])->name('settings');
                Route::put('/', [AppDownloaderSettingController::class, 'update'])->name('settings.update');
            });

            Route::group(['permission' => 'app-downloader.settings'], function (): void {
                Route::get('qr', QrCodeController::class)->name('qr');
                Route::post('files', [UploadController::class, 'store'])->name('files.store');
                Route::delete('files/{platform}', [UploadController::class, 'destroy'])->name('files.destroy');
            });
        });
});
