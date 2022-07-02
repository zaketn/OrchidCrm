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

            TD::make('users', 'Сотрудник')
                ->render(
                    fn (Meetup $meetup) => $meetup->users->where('company_id', 1)->implode('last_name', ', ')
                ),

            TD::make('customers', 'Заказчик')
                ->render(
                    fn (Meetup $meetup) => $meetup->users->where('company_id', '!=', 1)->implode('last_name', ', ')
                ),

            TD::make('address', 'Адрес встречи'),

            TD::make('place', 'Место встречи'),

            TD::make('date_time', 'Дата и время встречи'),
        ];
    }
}
