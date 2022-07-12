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
            Project::STATUS_STARTED => 'Создан',
            Project::STATUS_STOPPED => 'Приостановлен',
            Project::STATUS_DEV => 'В разработке',
            Project::STATUS_CANCELLED => 'Отменен',
            Project::STATUS_FINISHED => 'Завершен',
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
            Project::STATUS_STARTED => 'text-secondary',
            Project::STATUS_STOPPED => 'text-warning',
            Project::STATUS_DEV => 'text-primary',
            Project::STATUS_CANCELLED => 'text-danger',
            Project::STATUS_FINISHED => 'text-success',
            default => 'text-black',
        };
    }

    public function localizedDate() : string
    {
        $isCurrentYear = Carbon::create($this->entity->created_at)->year == Carbon::now()->year;

        if($isCurrentYear){
            return Carbon::create($this->entity->created_at)->translatedFormat('j F, g:i');
        }

        return Carbon::create($this->entity->created_at)->translatedFormat('j F Y, g:i');
    }
}
