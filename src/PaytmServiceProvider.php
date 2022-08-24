<?php

namespace TechTailor\Paytm;

use Illuminate\Support\Facades\Blade;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class PaytmServiceProvider extends PackageServiceProvider
{
    /* More info: https://github.com/spatie/laravel-package-tools */
    public function configurePackage(Package $package): void
    {
        $package->name('paytm')
            ->hasConfigFile()
            ->hasAssets();
    }

    public function packageBooted(): void
    {
        Blade::directive('paytmScripts', [PaytmBladeDirectives::class, 'paytmScripts']);
    }

    public function registeringPackage(): void
    {
        $this->app->singleton(Paytm::class);
        $this->app->alias(Paytm::class, 'paytm');
    }
}
