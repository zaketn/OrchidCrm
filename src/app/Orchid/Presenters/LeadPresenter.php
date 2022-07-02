<?php

namespace App\Orchid\Presenters;

use Orchid\Support\Presenter;

class LeadPresenter extends Presenter
{
    public function localizedStatus(): string
    {
        switch($this->entity->status) {
            case 'applied':
                return 'Одобрена';
            case 'declined':
                return 'Отклонена';
            case 'pending':
                return 'Ожидает';
        }
        return '';
    }
}
