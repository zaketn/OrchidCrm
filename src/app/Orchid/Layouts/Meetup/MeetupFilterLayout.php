<?php

namespace App\Orchid\Layouts\Meetup;

use App\Orchid\Filters\Meetup\MeetupDateFilter;
use App\Orchid\Filters\Meetup\MeetupStatusFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class MeetupFilterLayout extends Selection
{
    /**
     * @return Filter[]
     */
    public function filters(): iterable
    {
        return [
            MeetupStatusFilter::class,
        ];
    }
}
