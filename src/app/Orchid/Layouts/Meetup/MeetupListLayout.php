<?php

namespace App\Orchid\Layouts\Meetup;

use App\Models\Customer;
use App\Models\Meetup;
use App\Models\User;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class MeetupListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'meetups';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('id', '#')
                ->render(
                    fn (Meetup $meetup) => Link::make($meetup->id)->route('platform.meetups.edit', $meetup)
                ),

            TD::make('user_id', 'Сотрудник')
                ->render(
                    fn (Meetup $meetup) => $meetup->user->last_name.' '.$meetup->user->name.' '.$meetup->user->middle_name
                ),

            TD::make('customer_id', 'Заказчик')
                ->render(
                    fn (Meetup $meetup) => $meetup->customer->last_name.' '.$meetup->customer->name.' '.$meetup->customer->middle_name
                ),

            TD::make('address', 'Адрес встречи'),

            TD::make('place', 'Место встречи'),

            TD::make('date_time', 'Дата и время встречи'),
        ];
    }
}
