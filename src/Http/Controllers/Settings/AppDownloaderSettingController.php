<?php

namespace MainaSuperintelligence\AppDownloader\Http\Controllers\Settings;

use MainaSuperintelligence\AppDownloader\Forms\Settings\AppDownloaderSettingForm;
use MainaSuperintelligence\AppDownloader\Http\Requests\Settings\AppDownloaderSettingRequest;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Base\Supports\Breadcrumb;
use Botble\Setting\Http\Controllers\SettingController;

class AppDownloaderSettingController extends SettingController
{
    protected function breadcrumb(): Breadcrumb
    {
        return parent::breadcrumb()
            ->add(trans('core/base::base.panel.others'));
    }

    public function edit()
    {
        $this->pageTitle(trans('plugins/app-downloader::app-downloader.settings.title'));

        return AppDownloaderSettingForm::create()->renderForm();
    }

    public function update(AppDownloaderSettingRequest $request): BaseHttpResponse
    {
        return $this->performUpdate($request->validated());
    }
}
