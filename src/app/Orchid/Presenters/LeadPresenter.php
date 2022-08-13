<?php

namespace App\Orchid\Presenters;

use Illuminate\Support\Carbon;
use Orchid\Support\Presenter;
use App\Models\Lead;

class LeadPresenter extends Presenter
{
    /**
     * Transforms status from DB for easy reading
     *
     * @return string
     */
    public function localizedStatus(): string
    {
        return match ($this->entity->status) {
            Lead::STATUS_APPLIED => 'Одобрена',
            Lead::STATUS_DECLINED => 'Отклонена',
            Lead::STATUS_PENDING => 'На рассмотрении',
            default => '',
        };
    }

    /**
     * Return bootstrap text color class according to status
     *
     * @return string
     */
    public function statusColor() : string {
        return match ($this->entity->status) {
            Lead::STATUS_PENDING => 'text-warning',
            Lead::STATUS_DECLINED => 'text-danger',
            Lead::STATUS_APPLIED => 'text-success',
            default => 'text-black',
        };
    }
}
