<?php

declare(strict_types=1);

namespace App\Orchid\Screens;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;

class PlatformScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'metrics' => [
                'role' => Auth::user()->roles()->first()->name,
                'pendingTasks' => Auth::user()->pendingTasks()->count(),
                'finishedTasks' => Auth::user()->finishedTasks()->count(),
                'contribProjects' => Auth::user()->projects()->count(),
            ],

            'tables' => [
                'usersProjects' => Auth::user()
                    ->projects
                    ->where('status', '!=', Project::STATUS_FINISHED)
                    ->sortBy('created_at'),

                'usersTasks' => Auth::user()
                    ->tasks
                    ->where('status', '!=', Task::STATUS_FINISHED)
                    ->sortBy('deadline'),
            ]
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Здравствуйте, '. Auth::user()->name.'.';
    }

    /**
     * Display header description.
     *
     * @return string|null
     */
    public function description(): ?string
    {
        return 'Добро пожаловать в административную часть сайта.';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Мои встречи')
                ->route('platform.meetups', ['user_id' => Auth::user()])
                ->icon('event'),

            Link::make('Мои задачи')
                ->route(
                    'platform.tasks', ['filter' => ['user_id' => Auth::id()]])
                ->icon('task'),

            Link::make('Вернуться на сайт')
                ->route('index')
                ->icon('arrow-left-circle'),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): iterable
    {
        return [
            Layout::metrics([
                'Должность' => 'metrics.role',
                'Задачи в очереди' => 'metrics.pendingTasks',
                'Выполненные задачи' => 'metrics.finishedTasks',
                'Участие проектах' => 'metrics.contribProjects'
            ]),

            Layout::columns([
                Layout::table('tables.usersTasks', [
                   TD::make('header', 'Заголовок')
                       ->render(
                           fn(Task $task) => Link::make($task->header)->route('platform.tasks.edit', $task)
                       ),

                   TD::make('deadline', 'Крайний срок')->render(
                       fn(Task $task) => datetime_format($task->deadline)
                   ),

                    TD::make('status', 'Статус')->render(
                       fn(Task $task) => $task->presenter()->coloredDotsBeforeStatus()
                   ),
                ])
                    ->title('Задачи'),

                Layout::table('tables.usersProjects', [
                    TD::make('name', 'Название')
                        ->render(
                            fn(Project $project) => Link::make($project->name)
                                ->route('platform.projects.edit', $project)
                        ),

                    TD::make('status', 'Статус')
                        ->render(
                            fn(Project $project) => $project->presenter()->localizedStatus(true)
                        ),

                ])
                    ->title('Проекты'),
            ])
        ];
    }
}
