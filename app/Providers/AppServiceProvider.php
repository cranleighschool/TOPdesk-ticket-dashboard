<?php

namespace App\Providers;

use App\View\Components\DashboardTileContentComponent;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Blade::component('dashboard-tile-content', DashboardTileContentComponent::class);
    }
}
