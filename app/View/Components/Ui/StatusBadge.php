<?php

namespace App\View\Components\Ui;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class StatusBadge extends Component
{
    public string $status;

    public function __construct(string $status)
    {
        $this->status = strtolower($status);
    }

    public function classes(): string
    {
        return match ($this->status) {
            'scheduled' => 'bg-blue-50 text-blue-600 border border-blue-200',
            'completed' => 'bg-green-50 text-green-600 border border-green-200',
            'failed'    => 'bg-red-50 text-red-600 border border-red-200',
            default     => 'bg-gray-50 text-gray-600 border border-gray-200',
        };
    }

    public function label(): string
    {
        return ucfirst($this->status);
    }

    public function render()
    {
        return view('components.ui.status-badge');
    }
}
