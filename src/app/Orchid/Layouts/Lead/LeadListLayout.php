<?php

namespace App\Orchid\Layouts\Lead;

use App\Models\Lead;
use Illuminate\Support\Facades\Auth;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Persona;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class LeadListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'leads';

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
                    fn(Lead $lead) => Link::make($lead->id)->route('platform.leads.edit', $lead)
                )
                ->sort(),

            TD::make('header', 'Заголовок')->filter(Input::make()),

            TD::make('company', 'Компания')
                ->render(
                    fn(Lead $lead) => $lead->user->company->name
                ),

            TD::make('user_id', 'Представитель')
                ->render(
                    fn(Lead $lead) => new Persona($lead->user->presenter())
                ),

            TD::make('desired_date', 'Удобное время')
                ->render(
                    fn(Lead $lead) => $lead->presenter()->localizedDate()
                )
                ->filter(DateTimer::make()->format('Y-m-d'))
                ->sort(),

            TD::make('status', 'Статус')
                ->render(
                    fn(Lead $lead) => $lead->presenter()->localizedStatus()
                )
                ->sort()
                ->filter(
                    Select::make()
                        ->options([
                            Lead::STATUS_APPLIED => 'Принята',
                            Lead::STATUS_DECLINED => 'Отклонена',
                            Lead::STATUS_PENDING => 'На рассмотрении',
                        ])
                ),

            TD::make('actions', 'Действия')
                ->alignCenter()
                ->width('100px')
                ->render(function (Lead $lead) {
                    return DropDown::make()
                        ->icon('options-vertical')
                        ->list([
                            Link::make('Рассмотреть')->route('platform.leads.edit', $lead)
                        ]);
                })
                ->canSee(Auth::user()->hasAccess('platform.leads.edit')),
        ];
    }
}
