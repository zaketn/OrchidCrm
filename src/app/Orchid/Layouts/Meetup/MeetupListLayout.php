<?php

namespace App\Orchid\Layouts\Meetup;

use App\Models\Meetup;
use Illuminate\Support\Facades\Auth;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
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
                    fn(Meetup $meetup) => Link::make($meetup->id)->route('platform.meetups.edit', $meetup)
                )
                ->sort(),

            TD::make('users', 'Сотрудник')
                ->render(function (Meetup $meetup) {
                    return group_persons('Сотрудники', $meetup->employees()->get());
                }),

            TD::make('customers', 'Заказчик')
                ->render(
                    fn(Meetup $meetup) => group_persons('Заказчики', $meetup->customers()->get())
                ),

            TD::make('address', 'Адрес встречи')
                ->filter(Input::make())
                ->sort(),

            TD::make('date_time', 'Дата и время встречи')
                ->render(fn(Meetup $meetup) => datetime_format($meetup->date_time))
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
                            Link::make('Относящаяся заявка')
                                ->route('platform.leads.edit', $meetup->lead ?? '#')
                                ->canSee($meetup->lead()->exists())
                        ]);
                })
                ->canSee(Auth::user()->hasAccess('platform.meetups.edit'))
        ];
    }
}
