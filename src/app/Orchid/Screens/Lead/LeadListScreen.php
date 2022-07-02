<?php

namespace App\Orchid\Screens\Lead;

use App\Models\Lead;
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
            'leads' => Lead::filters()->defaultSort('status', 'desc')->paginate()
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

    public function description() : ?string
    {
        return 'Список всех, когда либо поступавших заявок';
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
            LeadListLayout::class
        ];
    }
}
