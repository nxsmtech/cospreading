<?php

namespace App\Providers;

use App\DataProviders\Contracts\ProvidesEventData;
use App\DataProviders\Contracts\ProvidesSensorData;
use App\DataProviders\GoogleCalendar\GoogleCalendarEventProvider;
use App\DataProviders\Mockoon\MockoonSensorDataProvider;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
       $this->app->bind(ProvidesSensorData::class, MockoonSensorDataProvider::class);
       $this->app->bind(ProvidesEventData::class, GoogleCalendarEventProvider::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }
}
