<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\User;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class UserEditLayout extends Rows
{
    /**
     * Views.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        return [
            Input::make('user.last_name')
                ->type('text')
                ->max(255)
                ->required()
                ->title('Фамилия')
                ->placeholder('Иванов'),

            Input::make('user.name')
                ->type('text')
                ->max(255)
                ->required()
                ->title('Имя')
                ->placeholder('Иван'),

            Input::make('user.middle_name')
                ->type('text')
                ->max(255)
                ->required()
                ->title('Отчество')
                ->placeholder('Иванович'),

            Input::make('user.phone')
                ->type('text')
                ->max(32)
                ->required()
                ->title('Телефон')
                ->placeholder('+79995497886'),

            Input::make('user.email')
                ->type('email')
                ->required()
                ->title(__('Email'))
                ->placeholder(__('Email')),
        ];
    }
}
