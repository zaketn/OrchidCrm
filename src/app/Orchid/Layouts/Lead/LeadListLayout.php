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
                ->render(function(Lead $lead){
                    return Link::make($lead->header)->route('platform.leads.edit', $lead);
                })
                ->render(
                    fn (Lead $lead) => Link::make($lead->header)->route('platform.leads.edit', $lead)
                ),

            TD::make('desired_date', 'Удобное время'),

            TD::make('customer_id', 'Компания')
                ->render(
                    fn (Lead $lead) => $lead->customer->company->name
                ),

            TD::make('customer_id', 'Имя представителя')
                ->render(
                    fn (Lead $lead) => $lead->customer->last_name.' '.$lead->customer->name.' '.$lead->customer->middle_name
                ),

            TD::make('status', 'Статус')
                ->render(
                    fn (Lead $lead) => Link::make($lead->presenter()->localizedStatus())->route('platform.leads.edit', $lead)
                )
                ->sort(),
        ];
    }
}
