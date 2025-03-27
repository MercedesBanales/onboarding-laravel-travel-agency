<?php

declare(strict_types=1);

namespace Lightit\Shared\App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CityTable extends Component
{
    public function __construct()
    {
        //
    }

    public function render(): View|Closure|string
    {
        return view('components.city-table');
    }
}
