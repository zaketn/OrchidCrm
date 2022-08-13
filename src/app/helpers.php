<?php

use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Support\Carbon;

if(! function_exists('datetime_format')){
    /**
     * Transforms DateTime field from DB for easy reading
     * If the DateTime's year is matches current year then j F, g:i, else j F Y, g:i
     *
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
