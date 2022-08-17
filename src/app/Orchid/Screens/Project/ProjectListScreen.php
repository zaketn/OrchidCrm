<?php

namespace App\Orchid\Screens\Project;

use App\Models\Project;
use App\Models\User;
use App\Orchid\Layouts\Project\ProjectListLayout;
use App\View\Components\PersonaMultiple;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class ProjectListScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'projects' => Project::filters()->paginate(15),
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Проекты';
    }

    public function description(): ?string
    {
        return 'Список всех проектов';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Создать проект')
                ->route('platform.projects.edit')
                ->icon('pencil')
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

            ProjectListLayout::class,
        ];
    }

    public function permissions(): iterable
    {
        return [
            'platform.projects'
        ];
    }

    public function asyncGetUsers($users): iterable
    {
        return [
            'users' => collect($users)->mapInto(User::class)
        ];
    }
}
