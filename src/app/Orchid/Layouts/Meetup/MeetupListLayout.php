<?php

namespace App\Orchid\Layouts\Meetup;

use App\Models\Meetup;
use Illuminate\Support\Facades\Auth;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Persona;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Illuminate\Database\Eloquent\Collection;

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
                    return $this->groupPersons('Сотрудники', $meetup->employees()->get());
                }),

            TD::make('customers', 'Заказчик')
                ->render(
                    fn(Meetup $meetup) => $this->groupPersons('Заказчики', $meetup->customers()->get())
                ),

            TD::make('address', 'Адрес встречи')
                ->filter(Input::make())
                ->sort(),

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
                            Link::make('Относящаяся заявка')
                                ->route('platform.leads.edit', $meetup->lead ?? '#')
                                ->canSee($meetup->lead()->exists())
                        ]);
                })
                ->canSee(Auth::user()->hasAccess('platform.meetups.edit'))
        ];
    }

    /**
     * Show modal window if meetup has more than one person.
     *
     * @param Collection $persons
     * @param string $title
     * @return ModalToggle|Persona
     */
    private function groupPersons(string $title, Collection $persons): Persona|ModalToggle
    {
        if ($persons->count() > 1) {
            return ModalToggle::make($persons->implode('firstAndLastName', ', '))
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
