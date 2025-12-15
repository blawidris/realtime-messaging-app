<?php

namespace App\View\Components\Ui;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TabPanel extends Component
{
    public $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function render(): View|Closure|string
    {
        return view('components.ui.tab-panel');
    }
}
