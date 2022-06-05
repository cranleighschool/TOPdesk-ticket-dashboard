<?php

namespace App\View\Components;

use Spatie\Dashboard\Http\Components\DashboardTileComponent;

class DashboardTileContentComponent extends DashboardTileComponent
{
    public function render()
    {
        return view('content-block');
    }
}
