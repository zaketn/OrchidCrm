<?php

namespace App\Orchid\Layouts\Lead;

use App\Orchid\Filters\Lead\LeadCompanyFilter;
use App\Orchid\Filters\Lead\LeadDateFilter;
use App\Orchid\Filters\Lead\LeadStatusFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class LeadFilterLayout extends Selection
{
    /**
     * @return Filter[]
     */
    public function filters(): iterable
    {
        return [
            LeadStatusFilter::class,
        ];
    }
}
