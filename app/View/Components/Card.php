<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Card extends Component
{
    public $margin;
    public $cardItems;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($margin, $cardItems)
    {
        $this->margin = $margin;
        $this->cardItems = $cardItems;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.card');
    }
}
