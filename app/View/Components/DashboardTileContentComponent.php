<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Spatie\Dashboard\Components\DashboardTileComponent;

class DashboardTileContentComponent extends DashboardTileComponent
{
    public function render(): View
    {
        return view('content-block');
    }
}
