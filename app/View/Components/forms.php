<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class forms extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public readonly array $inputs, public readonly string $type, public readonly string $route, public readonly bool $image = false)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.forms');
    }
}
