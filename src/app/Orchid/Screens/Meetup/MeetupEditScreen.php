<?php

namespace App\Orchid\Screens\Meetup;

use App\Models\Lead;
use App\Models\Meetup;
use App\Models\User;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class MeetupEditScreen extends Screen
{
    public Meetup $meetup;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Meetup $meetup): iterable
    {
        return [
            'meetup' => $meetup,
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->meetup->exists ? 'Редактирование встречи' : 'Создание встречи';
    }

    public function description(): ?string
    {
        return $this->meetup->exists ? 'Внимание! Изменяйте данные запланированной встречи только в случае крайней необходимости!' : null;
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Удалить')
                ->method('delete')
                ->canSee($this->meetup->exists)
                ->icon('trash'),

            Button::make('Сохранить')
                ->method('createOrUpdate')
                ->icon('pencil')
                ->canSee($this->meetup->exists),

            Button::make('Создать')
                ->method('createOrUpdate')
                ->icon('note')
                ->canSee(!$this->meetup->exists),
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
            Layout::rows([
                Relation::make('meetup.customers') //TODO fix showing customers when edit
                    ->title('Заказчик')
                    ->fromModel(User::class, 'name')
                    ->displayAppend('fullName')
                    ->chunk(50)
                    ->multiple()
                    ->required(),

                Relation::make('meetup.users')
                    ->title('Сотрудник')
                    ->fromModel(User::class, 'name')
                    ->displayAppend('fullName')
                    ->chunk(50)
                    ->multiple()
                    ->required(),

                Relation::make('meetup.lead_id')
                    ->title('На основе заявки: ')
                    ->fromModel(Lead::class, 'header')
                    ->chunk(50)
                    ->help('Может быть пустым'),

                Input::make('meetup.address')
                    ->title('Адрес')
                    ->required(),

                Input::make('meetup.place')
                    ->title('Место')
                    ->help('Может быть пустым'),

                DateTimer::make('meetup.date_time')
                    ->title('Дата и время')
                    ->enableTime()
                    ->required()
            ])
        ];
    }

    public function delete(Meetup $meetup)
    {
        $meetup->users()->detach();
        $meetup->delete();

        Alert::success('Встреча успешно удалена');

        return redirect()->route('platform.meetups');
    }

    public function createOrUpdate(Meetup $meetup, Request $request)
    {
        $meetup->fill($request->meetup)->save();
        $meetup->users()->attach($request->meetup['users']);
        $meetup->users()->attach($request->meetup['customers']);

        Alert::success('Успешно!');

        return redirect()->route('platform.meetups');
    }
}
