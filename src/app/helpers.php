<?php

use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Layouts\Persona;

if(! function_exists('datetime_format')){
    /**
     * Transforms DateTime field from DB for easy reading
     * If the DateTime's year is matches current year then j F, g:i, else j F Y, g:i
     *
     * @param string|null $dtField
     * @return string
     */

    function datetime_format(string|null $dtField) : string {
        try{
            $date = Carbon::createFromFormat('Y-m-d H:i:s', $dtField);

            $isCurrentYear = $date->year == Carbon::now()->year;

            if($isCurrentYear){
                return $date->translatedFormat('j F, g:i');
            }

            return $date->translatedFormat('j F Y, g:i');
        }
        catch (InvalidFormatException $e) {
            return '-';
        }
    }
}

if(! function_exists('group_persons')){
    /**
     * Show modal window if meetup has more than one person.
     *
     * @param Collection $persons
     * @param string $title
     * @return ModalToggle|Persona
     */
    function group_persons(string $title, Collection $persons): Persona|ModalToggle
    {
        if ($persons->count() > 1) {
            return ModalToggle::make($persons->implode('last_name', ', '))
                ->modal('groupPersonsModal')
                ->modalTitle($title)
                ->asyncParameters([
                    'users' => $persons
                ]);
        }
        else
            return new Persona($persons->first()->presenter());
    }
}
