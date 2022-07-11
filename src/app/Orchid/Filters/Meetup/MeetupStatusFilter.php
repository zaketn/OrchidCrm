<?php

namespace App\Orchid\Filters\Meetup;

use App\Models\Meetup;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Radio;

class MeetupStatusFilter extends Filter
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
        $operator = match ($this->request->status) {
            Meetup::STATUS_ARRANGED => '>',
            Meetup::STATUS_PAST => '<'
        };

        return $builder->whereDate('date_time', $operator, Carbon::now())->orderBy('date_time');
    }

    /**
     * Get the display fields.
     *
     * @return Field[]
     */
    public function display(): iterable
    {
        return [
            Radio::make('status')
                ->placeholder('Запланированные')
                ->title('По статусу')
                ->value(Meetup::STATUS_ARRANGED)
                ->checked($this->request->status == Meetup::STATUS_ARRANGED),

            Radio::make('status')
                ->placeholder('Прошедшие')
                ->value(Meetup::STATUS_PAST)
                ->checked($this->request->status == Meetup::STATUS_PAST),
        ];
    }
}
