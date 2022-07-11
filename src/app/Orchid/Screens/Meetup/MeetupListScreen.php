<?php

namespace App\Orchid\Screens\Meetup;

use App\Models\Meetup;
use App\Orchid\Filters\Meetup\MeetupDateFilter;
use App\Orchid\Filters\Meetup\MeetupStatusFilter;
use App\Orchid\Layouts\Meetup\MeetupFilterLayout;
use App\Orchid\Layouts\Meetup\MeetupListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class MeetupListScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'meetups' => Meetup::filters()
                ->filtersApply([MeetupDateFilter::class, MeetupStatusFilter::class])
                ->orderBy('date_time', 'desc')
                ->paginate()
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Встречи c заказчиками';
    }

    public function description(): ?string
    {
        return 'Список всех встреч. Для удобства можете пользоваться фильтрами.';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Создать встречу')
                ->route('platform.meetups.edit')
                ->icon('pencil'),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            MeetupFilterLayout::class,
            MeetupListLayout::class,
        ];
    }
}
