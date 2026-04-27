<?php

namespace App\Providers;

use App\Contracts\OfferRepositoryInterface;
use App\Notifications\EmailNotification;
use App\Notifications\SmsNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(OfferRepositoryInterface::class, \App\Repositories\OfferRepository::class);
        // $this->app->bind(\App\Contracts\NotificationServiceInterface::class,EmailNotification::class);
            // يمكنك اختيار نوع الإشعار الذي تريد استخدام
        // $this->app->bind(\App\Contracts\NotificationServiceInterface::class,SmsNotification::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::shouldBeStrict(! app()->isProduction());
    }
}
