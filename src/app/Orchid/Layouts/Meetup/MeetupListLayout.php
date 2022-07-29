<?php

namespace App\Orchid\Layouts\Meetup;

use App\Models\Meetup;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
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
        /**
         * TODO filter by customer
         * TODO filter by employee
         * TODO improve display of customer and employee
         */

        return [
            TD::make('id', '#')
                ->render(
                    fn(Meetup $meetup) => Link::make($meetup->id)->route('platform.meetups.edit', $meetup)
                )
                ->sort(),

            TD::make('users', 'Сотрудник')
                ->render(
                    fn(Meetup $meetup) => $meetup->employees()->get()->implode('last_name', ', ')
                ),

            TD::make('customers', 'Заказчик')
                ->render(
                    fn(Meetup $meetup) => $meetup->customers()->get()->implode('last_name', ', ')
                ),

            TD::make('address', 'Адрес встречи')
                ->filter(Input::make())
                ->sort(),

            TD::make('place', 'Место встречи'),

            TD::make('date_time', 'Дата и время встречи')
                ->render(fn(Meetup $meetup) => $meetup->presenter()->localizedDate())
                ->filter(TD::FILTER_DATE)
                ->sort(),

            TD::make('actions', 'Действия')
                ->alignCenter()
                ->width('100px')
                ->render(function (Meetup $meetup) {
                    return DropDown::make()
                        ->icon('options-vertical')
                        ->list([
                            Link::make('Просмотреть')->route('platform.meetups.edit', $meetup),
                        ]);
                })
                ->canSee(Auth::user()->hasAccess('platform.meetups.edit'))
        ];
    }
}
