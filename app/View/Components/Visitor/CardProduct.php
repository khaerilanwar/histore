<?php

namespace App\View\Components\Visitor;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CardProduct extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public int $index,
        public object $product
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.visitor.card-product');
    }
}
