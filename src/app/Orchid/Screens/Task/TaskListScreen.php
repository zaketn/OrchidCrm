<?php

namespace App\Orchid\Screens\Task;

use App\Models\Task;
use App\Orchid\Layouts\Task\TaskListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class TaskListScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'tasks' => Task::paginate()
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Задачи';
    }

    /**
     * The description is displayed on the user's screen under the heading
     *
     * @return string|null
     */
    public function description() : ?string
    {
        return 'Список задач для всех работников.';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Создать задачу')
                ->route('platform.tasks.edit')
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
            TaskListLayout::class
        ];
    }
}
