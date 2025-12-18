<?php

namespace App\View\Components\Ui;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Tabs extends Component
{


    public function __construct(
        public ?string $active = null,
        public string $variant = 'default',
        public string $direction = 'horizontal',
    ) {}

    public function render(): View|Closure|string
    {
        return view('components.ui.tabs');
    }
}
