<?php

namespace App\View\Components\Home;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class LandscapeCard extends Component
{
    public $route;
    public $title;
    public $image;
    public $badge;
    public $meta;




    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.home.landscape-card');
    }
}
