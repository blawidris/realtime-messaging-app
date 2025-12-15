<?php

namespace App\View\Components\Ui;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Tabs extends Component
{

    public $active;

    public function __construct($active = null)
    {
        $this->active = $active;
    }

    public function render(): View|Closure|string
    {
        return view('components.ui.tabs');
    }
}
