<?php

namespace App\Orchid\Layouts\Lead;

use App\Models\Lead;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
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
            TD::make('id', 'ID')->sort(),

            TD::make('header', 'Заголовок')
                ->align(TD::ALIGN_LEFT)
                ->render(function (Lead $lead) {
                    return Link::make($lead->header)->route('platform.leads.edit', $lead);
                })
                ->render(
                    fn(Lead $lead) => Link::make($lead->header)->route('platform.leads.edit', $lead)
                ),

            TD::make('desired_date', 'Удобное время')
                ->render(
                    fn(Lead $lead) => $lead->presenter()->localizedDate()
                )
                ->sort(),

            TD::make('user_id', 'Компания')
                ->render(
                    fn(Lead $lead) => $lead->user->company->name
                ),

            TD::make('user_id', 'Имя представителя')
                ->render(
                    fn(Lead $lead) => $lead->user->presenter()->fullName()
                ),

            TD::make('status', 'Статус')
                ->render(
                    fn(Lead $lead) => $lead->presenter()->localizedStatus()
                )
                ->sort(),

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
        ];
    }
}
