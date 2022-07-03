<?php

namespace App\Orchid\Presenters;

use Illuminate\Support\Carbon;
use Orchid\Support\Presenter;
use App\Models\Lead;

class LeadPresenter extends Presenter
{
    public function localizedStatus(): string
    {
        return match ($this->entity->status) {
            'applied' => 'Одобрена',
            'declined' => 'Отклонена',
            'pending' => 'В обработке',
            default => '',
        };
    }

    public function statusColor() : string {
        return match ($this->entity->status) {
            Lead::STATUS_PENDING => 'text-warning',
            Lead::STATUS_DECLINED => 'text-danger',
            Lead::STATUS_APPLIED => 'text-success',
            default => 'text-black',
        };
    }

    public function localizedTime() : string {
        return Carbon::create($this->entity->desired_date)->translatedFormat('j F Y, g:i');
    }
}
