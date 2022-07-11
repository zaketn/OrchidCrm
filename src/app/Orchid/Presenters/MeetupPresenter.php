<?php

namespace App\Orchid\Presenters;

use Illuminate\Support\Carbon;
use Orchid\Support\Presenter;

class MeetupPresenter extends Presenter
{
    /**
     * Transforms DateTime field from DB for easy reading
     * If the DateTime's year is matches current year then include it
     *
     * @return string
     */
    public function localizedDate() : string {
        $isCurrentYear = Carbon::create($this->entity->date_time)->year == Carbon::now()->year;

        if($isCurrentYear){
            return Carbon::create($this->entity->date_time)->translatedFormat('j F, g:i');
        }

        return Carbon::create($this->entity->date_time)->translatedFormat('j F Y, g:i');
    }
}
