<?php

namespace App\Orchid\Screens\Meetup;

use App\Models\Meetup;
use App\Models\User;
use App\Orchid\Layouts\Meetup\MeetupFilterLayout;
use App\Orchid\Layouts\Meetup\MeetupListLayout;
use App\View\Components\PersonaMultiple;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class MeetupListScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'meetups' => Meetup::filters()
                ->filtersApplySelection(MeetupFilterLayout::class)
                ->orderBy('date_time', 'desc')
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
        return 'Встречи c заказчиками';
    }

    public function description(): ?string
    {
        return 'Список всех встреч. Для удобства можете пользоваться фильтрами.';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Создать встречу')
                ->route('platform.meetups.edit')
                ->icon('pencil'),
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
            Layout::modal('groupPersonsModal', Layout::component(PersonaMultiple::class))
                ->withoutApplyButton()
                ->async('asyncGetUsers'),

            MeetupFilterLayout::class,
            MeetupListLayout::class,
        ];
    }

    public function asyncGetUsers($users): iterable
    {
        return [
            'users' => collect($users)->mapInto(User::class)
        ];
    }

    public function permission(): ?iterable
    {
        return [
            'platform.meetups',
            'platform.meetups.edit',
        ];
    }
}
