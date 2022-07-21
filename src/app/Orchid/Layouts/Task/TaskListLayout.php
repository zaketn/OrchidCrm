<?php

namespace App\Orchid\Layouts\Task;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class TaskListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'tasks';

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
                    fn(Task $task) => Link::make($task->id)->route('platform.tasks.edit', $task)
                )
                ->sort(),

            TD::make('header', 'Тема')
                ->filter(Input::make()),

            TD::make('user_id', 'Сотрудник')
                ->render(
                    fn(Task $task) => $task->user->presenter()->fullName()
                )
                ->filter(
                    Select::make()
                        ->fromQuery(User::has('tasks'), 'name')
                        ->empty()
                )
                ->canSee(Auth::user()->hasAccess('platform.tasks.edit')),

            TD::make('project_id', 'Проект')
                ->render(
                    fn(Task $task) => Link::make($task->project->name)
                )
                ->filter(
                    Select::make()
                        ->fromQuery(Project::has('tasks'), 'name')
                        ->empty()
                ),

            TD::make('created_at', 'Назначена')
                ->render(
                    fn(Task $task) => $task->presenter()->localizedDate('created_at')
                )
                ->sort()
                ->filter(DateTimer::make()->format('Y-m-d')),

            TD::make('deadline', 'Крайний срок')
                ->render(
                    fn(Task $task) => $task->presenter()->localizedDate('deadline')
                ),

            TD::make('status', 'Статус'),

            TD::make('Действия')
                ->render(function (Task $task) {
                    return DropDown::make()
                        ->list([
                            Link::make('Перейти')->route('platform.tasks.edit', $task),
                        ])
                        ->icon('options-vertical');
                })
                ->width('100px')
                ->alignCenter()
        ];
    }
}
