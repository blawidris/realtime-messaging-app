<?php


namespace App\View\Components\Ui;

use Illuminate\View\Component;

class SwitchToggle extends Component
{
    public function __construct(
        public bool $checked = false,
        public bool $disabled = false,
        public string $size = 'md',
        public ?string $label = null,
        public ?string $name = null,
    ) {}

    public function render()
    {
        return view('components.ui.switch-toggle');
    }
}
