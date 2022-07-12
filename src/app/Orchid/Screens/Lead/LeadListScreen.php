<?php

namespace App\Orchid\Screens\Lead;

use App\Models\Lead;
use App\Orchid\Filters\Lead\LeadCompanyFilter;
use App\Orchid\Filters\Lead\LeadDateFilter;
use App\Orchid\Filters\Lead\LeadStatusFilter;
use App\Orchid\Layouts\Lead\LeadFilterLayout;
use App\Orchid\Layouts\Lead\LeadListLayout;
use Orchid\Screen\Screen;

class LeadListScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'leads' => Lead::filters()->filtersApply([
                LeadStatusFilter::class,
                LeadCompanyFilter::class,
                LeadDateFilter::class,
            ])
                ->orderBy('desired_date', 'desc')
                ->paginate()
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Заявки';
    }

    public function description(): ?string
    {
        return 'Список всех, когда либо поступавших заявок. Для удобства используйте фильтры.';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [

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
            LeadFilterLayout::class,
            LeadListLayout::class,
        ];
    }

    public function permission() : ?iterable
    {
        return [
            'platform.leads',
            'platform.leads.edit',
        ];
    }
}
