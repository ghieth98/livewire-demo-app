<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class select2 extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public mixed $options)
    {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): Factory|\Illuminate\Foundation\Application|View|Htmlable|string|Closure|Application
    {
        return view('components.select2');
    }
}
