<?php

namespace App\View\Components\Ui;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Modal extends Component
{

    public function __construct(public string $maxWidth = '2xl')
    {
        $this->maxWidth = $maxWidth;
    }

    public function maxWidthClass(): string
    {
        return match ($this->maxWidth) {
            'xs' => 'max-w-xs',
            'sm' => 'max-w-sm',
            'md' => 'max-w-md',
            'lg' => 'max-w-lg',
            'xl' => 'max-w-xl',
            '2xl' => 'max-w-2xl',
            '3xl' => 'max-w-3xl',
            default => $this->maxWidth,
        };
    }

    public function render(): View|Closure|string
    {
        return view('components.ui.modal');
    }
}
