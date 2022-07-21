<?php

namespace App\Orchid\Presenters;

use Illuminate\Support\Carbon;
use Orchid\Support\Presenter;

class TaskPresenter extends Presenter
{
    /**
     * Transforms DateTime field from DB for easy reading
     * If the DateTime's year is matches current year then include it
     *
     * @param string $dtValue
     * @return string
     */
    public function localizedDate(string $dtValue): string
    {
        $dtValue = $this->entity->$dtValue;

        if (isset($dtValue)) {
            $isCurrentYear = Carbon::create($dtValue)->year == Carbon::now()->year;
            $dateFormat = $isCurrentYear ? 'j F, g:i' : 'j F Y, g:i';
            return Carbon::create($dtValue)->translatedFormat($dateFormat);
        }
        return '-';
    }


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
}
