<?php

namespace App\Orchid\Layouts\Task;

use App\Models\Task;
use Orchid\Screen\Actions\Link;
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
        /**
         * TODO user link to user page
         * TODO project link to project page
         * TODO add filters
         */

        return [
            TD::make('id', 'No'),

            TD::make('header', 'Тема')
            ->render(
                fn(Task $task) => Link::make($task->header)->route('platform.tasks.edit', $task)
            ),

            TD::make('user_id', 'Ответственный')
                ->render(
                    fn (Task $task) => Link::make($task->user->presenter()->fullName())
                ),

            TD::make('project_id', 'Проект')
                ->render(
                    fn (Task $task) => Link::make($task->project->name)
                ),

            TD::make('finished', 'Выполнение')
                ->render(
                    fn (Task $task) => $task->finished ? 'Да' : 'Нет'
                ),

            TD::make('hours', 'Время на выполнение'),

            TD::make('start_date', 'Начало выполнения'),
            TD::make('end_date', 'Конец выполнения'),
        ];
    }
}
