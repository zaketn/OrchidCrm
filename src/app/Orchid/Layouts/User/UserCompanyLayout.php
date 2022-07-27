<?php

namespace App\Orchid\Layouts\User;

use App\Models\Company;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;

class UserCompanyLayout extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;

    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): iterable
    {
        return [
            Select::make('user.company')
                ->fromModel(Company::class, 'name')
                ->title('Название')
                ->required()
        ];
    }
}
