<?php

namespace App\Orchid\Presenters;

use Orchid\Support\Presenter;

class CustomerPresenter extends Presenter
{
    public function fullName() : string
    {
        return $this->entity->last_name.' '.$this->entity->name.' '.$this->entity->middle_name;
    }
}
