<?php

namespace App\View\Components\Ui;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Tab extends Component
{
    public $name;
    public $icon;
    public $active;

    public function __construct($name, $icon = null, $active = false)
    {
        $this->name = $name;
        $this->icon = $icon;
        $this->active = $active;
    }

    
    public function render(): View|Closure|string
    {
        return view('components.ui.tab');
    }
}
