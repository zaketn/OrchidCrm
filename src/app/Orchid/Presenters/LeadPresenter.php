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
            Lead::STATUS_APPLIED => '<i class="text-success">●</i> Одобрена',
            Lead::STATUS_DECLINED => '<i class="text-danger">●</i> Отклонена',
            Lead::STATUS_PENDING => '<i class="text-warning">●</i> На рассмотрении',
            default => '',
        };
    }
}
