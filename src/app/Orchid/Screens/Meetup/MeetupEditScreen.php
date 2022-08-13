<?php

namespace App\Orchid\Screens\Meetup;

use App\Models\Lead;
use App\Models\Meetup;
use App\Models\User;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

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
            Link::make('Относящаяся заявка')
                ->icon('envelope')
                ->route('platform.leads.edit', $this->meetup->lead)
                ->canSee($this->meetup->exists),

            Button::make('Удалить')
                ->method('delete')
                ->canSee($this->meetup->exists)
                ->confirm('Вы уверены, что хотите удалить встречу?')
                ->icon('trash'),

            Button::make('Сохранить')
                ->method('createOrUpdate')
                ->canSee($this->meetup->exists)
                ->confirm('Данные о встрече необходимо изменять, предварительно согласовав это со всеми её участниками.
                Вы уверены, что хотите это сделать?')
                ->icon('pencil'),

            Button::make('Создать')
                ->method('createOrUpdate')
                ->icon('note')
                ->canSee(! $this->meetup->exists),
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
                Relation::make('meetup.customers')
                    ->title('Заказчик')
                    ->fromModel(User::class, 'name')
                    ->displayAppend('fullName')
                    ->applyScope('customers')
                    ->chunk(50)
                    ->multiple()
                    ->required(),

                Relation::make('meetup.employees')
                    ->title('Сотрудник')
                    ->fromModel(User::class, 'name')
                    ->displayAppend('fullName')
                    ->applyScope('employees')
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

    public function permission(): ?iterable
    {
        return [
            'platform.meetups.edit',
        ];
    }

    public function delete(Meetup $meetup)
    {
        $meetup->users()->detach();
        $meetup->delete();

        Toast::success('Встреча успешно удалена');

        return redirect()->route('platform.meetups');
    }

    public function createOrUpdate(Meetup $meetup, Request $request)
    {
        $request->validate([
            'meetup.address' => 'required|between:0,128',
            'meetup.place' => 'between:0,128',
        ]);

        $meetupUsers = array_merge($request->meetup['employees'], $request->meetup['customers']);

        $meetup->fill($request->meetup)->save();
        $meetup->users()->sync($meetupUsers);

        Toast::success('Успешно!');

        return redirect()->route('platform.meetups');
    }
}
