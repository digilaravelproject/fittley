<?php

namespace App\View\Components\home;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PortraitCard extends Component
{
    public $video;
    public $badge = Null;
    public $badgeClass = Null;
    public $url;
    /**
     * Create a new component instance.
     */
    public function __construct($video, $url, $badge = null, $badgeClass = null)
    {
        $this->video = $video;
        $this->badge = $badge;
        $this->badgeClass = $badgeClass;
        $this->url = $url;
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.home.portrait-card');
    }
}
