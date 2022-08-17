<?php

namespace App\Orchid\Layouts\Project;

use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ProjectListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'projects';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('id', '#')
                ->render(
                    fn(Project $project) => Link::make($project->id)->route('platform.projects.edit', $project)
                )
                ->sort(),

            TD::make('name', 'Название')
                ->filter(TD::FILTER_TEXT),

            TD::make('user', 'Команда')
                ->render(function(Project $project){
                    return group_persons('Команда', $project->employees()->get());
                }),

            TD::make('status', 'Статус')
                ->render(
                    fn(Project $project) => $project->presenter()->localizedStatus()
                )
                ->filter(TD::FILTER_SELECT, [
                    Project::STATUS_CANCELLED => 'Отменен',
                    Project::STATUS_FINISHED => 'Завершен',
                    Project::STATUS_STARTED => 'В разработке',
                    Project::STATUS_STOPPED => 'Приостановлен',
                ]),

            TD::make('repo_link', 'Репозиторий')
                ->render(
                    fn(Project $project) => Link::make('Ссылка')->href($project->repo_link)->target('_blank')
                ),

            TD::make('contract', 'Договор')
                ->render(
                    fn(Project $project) => Link::make('Договор № '.$project->contract->id)
                ),

            TD::make('created_at', 'Создан')
                ->render(
                    fn(Project $project) => datetime_format($project->created_at)
                )
                ->sort()
                ->filter(TD::FILTER_DATE),

            TD::make('actions', 'Действия')
                ->alignCenter()
                ->width('100px')
                ->render(function (Project $project) {
                    return DropDown::make()
                        ->icon('options-vertical')
                        ->list([
                            Link::make('Просмотреть')->route('platform.projects.edit', $project)
                        ]);
                })
                ->canSee(Auth::user()->hasAccess('platform.projects.edit')),
        ];
    }
}
