<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PersonaMultiple extends Component
{
    public $users;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($users = [])
    {
        $this->users = $users;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.persona-multiple');
    }
}
