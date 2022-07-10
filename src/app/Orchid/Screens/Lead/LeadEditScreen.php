<?php

namespace App\Orchid\Screens\Lead;

use App\Models\Lead;
use App\Models\Meetup;
use App\Models\User;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class LeadEditScreen extends Screen
{
    public Lead $lead;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Lead $lead): iterable
    {
        return [
            'lead' => $lead
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Заявка #' . $this->lead->id;
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Отклонить')
                ->modal('declineModal')
                ->method('decline')
                ->icon('ban'),

            ModalToggle::make('Принять')
                ->modal('applyModal')
                ->icon('check')
                ->method('apply'),
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
            Layout::modal('declineModal', [
               Layout::rows([
                   TextArea::make('lead.employee_message')
                   ->title('Напишите причину отказа')
                   ->help('Дайте заказчику понять почему мы не можем принять его заявку')
                   ->rows(7)
                   ->required()
               ])
            ])
            ->title('Отказ на заявку')
            ->applyButton('Отправить')
            ->closeButton('Отмена'),

            Layout::modal('applyModal', [
               Layout::rows([
                   Relation::make('meetup.user_id')
                       ->title('Заказчик встретится с данным сотрудником: ')
                       ->fromModel(User::class, 'name')
                       ->displayAppend('fullName')
                       ->chunk(30)
                       ->required(),

                   Input::make('meetup.address')
                       ->placeholder('ул. Тверская, 75')
                       ->title('Адрес'),

                   Input::make('meetup.place')
                       ->title('Место встречи')
                       ->placeholder('Кафе "Вкусные снеки" на первом этаже')
                       ->help('Может быть пустым'),

                   DateTimer::make('lead.desired_date')
                       ->title('Дата и время встречи')
                       ->enableTime()
                       ->disabled()
                       ->help('Выбрано заказчиком')

               ])
            ])
            ->title('Отлично! Давайте создадим встречу')
            ->applyButton('Создать')
            ->closeButton('Отмена'),

            Layout::rows([
                Relation::make('lead.user_id')
                    ->title('Заказчик')
                    ->fromModel(User::class, 'name')
                    ->displayAppend('fullName')
                    ->disabled(),

                Input::make('lead.header')
                    ->title('Заголовок')
                    ->readonly(),

                Quill::make('lead.description')
                    ->title('Описание')
                    ->readonly(),

                DateTimer::make('lead.desired_date')
                    ->title('Выбранные дата и время')
                    ->enableTime()
                    ->help('Дата и время выбираются заказчиком')
                    ->disabled(),

                Input::make('lead.status')
                    ->title('Статус')
                    ->disabled()
            ])
        ];
    }

    public function decline(Lead $lead, Request $request)
    {
        $lead->status = $lead::STATUS_DECLINED;
        $lead->employee_message = $request->lead['employee_message'];
        $lead->save();

        Alert::success('Заявка #'.$lead->id.' отклонена. Рекомендуется связаться с пользователем для организации встречи.');

        return redirect()->route('platform.leads');
    }

    public function apply(Lead $lead, Request $request)
    {
        $meetup = Meetup::create([
            'user_id' => $request->meetup['user_id'],
            'address' => $request->meetup['address'],
            'place' => $request->meetup['place'],
            'date_time' => $request->lead['desired_date']
        ]);

        $meetup->users()->attach($request->lead['user_id']);
        $meetup->users()->attach($request->meetup['user_id']);

        $lead->status = $lead::STATUS_APPLIED;
        $lead->save();

        Alert::success('Заявка #'.$lead->id.' принята. На ее основе создана встреча #'.$meetup->id);

        return redirect()->route('platform.leads');
    }
}
