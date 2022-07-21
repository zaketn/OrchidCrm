<?php

namespace App\Orchid\Screens\Task;

use App\Models\Task;
use App\Orchid\Layouts\Task\TaskListLayout;
use Illuminate\Support\Facades\Auth;
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
        if (Auth::user()->hasAccess('platform.tasks.edit')) {
            return [
                'tasks' => Task::filters()
                    ->orderBy('created_at', 'desc')
                    ->paginate()
            ];
        }
        return [
            'tasks' => Auth::user()->tasks()->filters()
                ->orderBy('created_at', 'desc')
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
        return 'Задачи';
    }

    /**
     * The description is displayed on the user's screen under the heading
     *
     * @return string|null
     */
    public function description(): ?string
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
                ->canSee(Auth::user()->hasAccess('platform.tasks.edit'))
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

    public function permission(): ?iterable
    {
        return [
            'platform.tasks',
            'platform.tasks.edit'
        ];
    }
}
