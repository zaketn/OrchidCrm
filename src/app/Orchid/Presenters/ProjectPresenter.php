<?php

namespace App\Orchid\Presenters;

use App\Models\Lead;
use App\Models\Project;
use Illuminate\Support\Carbon;
use Orchid\Support\Presenter;

class ProjectPresenter extends Presenter
{
    /**
     * Transforms status from DB for easy reading.
     * Dot with color depending on status could be added optionally.
     *
     * @param bool $coloredDot
     * @return string
     */
    public function localizedStatus(bool $coloredDot = false): string
    {
        $status = match ($this->entity->status) {
            Project::STATUS_STARTED => 'В разработке',
            Project::STATUS_STOPPED => 'Приостановлен',
            Project::STATUS_CANCELLED => 'Отменен',
            Project::STATUS_FINISHED => 'Завершен',
            default => '',
        };

        if ($coloredDot) {
            $dotColor = match ($this->entity->status) {
                Project::STATUS_STARTED => '<i class="text-primary">●</i> ',
                Project::STATUS_STOPPED => '<i class="text-warning">●</i> ',
                Project::STATUS_CANCELLED => '<i class="text-danger">●</i> ',
                Project::STATUS_FINISHED => '<i class="text-success">●</i> ',
            };

            $status = $dotColor . $status;
        }

        return $status;
    }
}
