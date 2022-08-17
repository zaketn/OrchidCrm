<?php

namespace App\Orchid\Presenters;

use App\Models\Lead;
use App\Models\Project;
use Illuminate\Support\Carbon;
use Orchid\Support\Presenter;

class ProjectPresenter extends Presenter
{
    /**
     * Transforms status from DB for easy reading
     *
     * @return string
     */
    public function localizedStatus(): string
    {
        return match ($this->entity->status) {
            Project::STATUS_STARTED => '<i class="text-primary">●</i> В разработке',
            Project::STATUS_STOPPED => '<i class="text-warning">●</i> Приостановлен',
            Project::STATUS_CANCELLED => '<i class="text-danger">●</i> Отменен',
            Project::STATUS_FINISHED => '<i class="text-success">●</i> Завершен',
            default => '',
        };
    }
}
