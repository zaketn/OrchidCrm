<?php

namespace App\Orchid\Screens\Meetup;

use App\Models\Meetup;
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
            'meetups' => Meetup::paginate()
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
        return 'Список всех встреч';
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
            MeetupListLayout::class
        ];
    }
}
