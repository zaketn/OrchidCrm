<?php

namespace App\Orchid\Filters\Lead;

use App\Models\Lead;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Select;

class LeadStatusFilter extends Filter
{
    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string
    {
        return 'Статус';
    }

    /**
     * The array of matched parameters.
     *
     * @return array|null
     */
    public function parameters(): ?array
    {
        return ['status'];
    }

    /**
     * Apply to a given Eloquent query builder.
     *
     * @param Builder $builder
     *
     * @return Builder
     */
    public function run(Builder $builder): Builder
    {
        return $builder->where('status', $this->request->status);
    }

    /**
     * Get the display fields.
     *
     * @return Field[]
     */
    public function display(): iterable
    {
        return [
            Select::make('status')
                ->options([
                    Lead::STATUS_PENDING => 'На рассмотрении',
                    Lead::STATUS_DECLINED => 'Отклонена',
                    Lead::STATUS_APPLIED => 'Одобрена',
                ])
                ->empty()
                ->value($this->request->status)
                ->title('Статус')
        ];
    }
}
