<?php

namespace App\Orchid\Filters\Lead;

use App\Models\Company;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Select;

class LeadCompanyFilter extends Filter
{
    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string
    {
        return 'Компания';
    }

    /**
     * The array of matched parameters.
     *
     * @return array|null
     */
    public function parameters(): ?array
    {
        return ['company'];
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
        return $builder->whereHas('user', function (Builder $query) {
            $query->where('company_id', $this->request->company);
        });
    }

    /**
     * Get the display fields.
     *
     * @return Field[]
     */
    public function display(): iterable
    {
        return [
            Select::make('company')
                ->fromModel(Company::class, 'name', 'id')
                ->empty()
                ->value($this->request->company)
                ->title('Компания')
        ];
    }
}
