<?php

namespace App\Orchid\Presenters;

use App\Models\Task;
use Illuminate\Support\Carbon;
use Orchid\Support\Presenter;

class TaskPresenter extends Presenter
{
    /**
     * Calculate difference between two dates and make it readable
     *
     * @param string|null $startDt
     * @param string|null $endDt
     * @return string
     */
    public function readableTimeDiff(string|null $startDt, string|null $endDt = 'now') : string
    {
        return Carbon::parse($startDt)->diffForHumans($endDt, [
            'syntax' => Carbon::DIFF_ABSOLUTE,
            'parts' => 4,
            'join' => ', ',
        ]);
    }

    public function coloredDotsBeforeStatus()
    {
        return match ($this->entity->status) {
            Task::STATUS_STARTED => '<i class="text-primary">●</i> '.$this->entity->status,
            Task::STATUS_CREATED => '<i class="text-warning">●</i> '.$this->entity->status,
            Task::STATUS_FINISHED => '<i class="text-success">●</i> '.$this->entity->status,
            default => '',
        };
    }
}
