<?php

namespace App\Orchid\Screens\Task;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class TaskEditScreen extends Screen
{
    public $task;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Task $task): iterable
    {
        return [
            'task' => $task,

            'metrics' => [
                'startDate' => $task->presenter()->localizedDate('start_date'),
                'endDate' => $task->presenter()->localizedDate('end_date'),
                'runtime' => $task->runtime,
                'status' => $task->status,
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
        return $this->task->exists ? 'Задача' . ' ' . $this->task->header : 'Создать новую задачу';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Удалить')
                ->method('delete')
                ->canSee($this->task->exists && Auth::user()->hasAccess('platform.tasks.edit'))
                ->confirm('Вы действительно хотите удалить задачу?')
                ->icon('trash'),

            Button::make('Обновить задачу')
                ->method('createOrUpdate')
                ->canSee($this->task->exists && Auth::user()->hasAccess('platform.tasks.edit'))
                ->icon('pencil'),

            Button::make('Создать задачу')
                ->method('createOrUpdate')
                ->canSee(!$this->task->exists)
                ->icon('pencil'),

            Button::make(empty($this->task->start_date) ? 'Начать' : 'Продолжить')
                ->method('startTask')
                ->canSee(
                    $this->task->exists
                    && $this->task->user->id == Auth::user()->id
                    && ($this->task->status == Task::STATUS_CREATED || $this->task->status == Task::STATUS_FINISHED)
                )
                ->icon('control-play'),

            Button::make('Завершить')
                ->method('endTask')
                ->canSee(
                    $this->task->exists
                    && $this->task->user->id == Auth::user()->id
                    && $this->task->status == Task::STATUS_STARTED
                )
                ->icon('control-pause'),
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
            Layout::metrics([
                'Статус' => 'metrics.status',
                'Начало выполнения' => 'metrics.startDate',
                'Конец выполнения' => 'metrics.endDate',
                'Время выполнения' => 'metrics.runtime',
            ])
                ->canSee($this->task->exists),

            Layout::rows([
                Relation::make('task.project_id')
                    ->title('Проект')
                    ->fromModel(Project::class, 'name')
                    ->applyScope('started')
                    ->searchColumns('name', 'repo_link')
                    ->chunk(30)
                    ->help('Вы можете найти проект введя его название или ссылку на репозиторий в поиск')
                    ->disabled(!Auth::user()->hasAccess('platform.tasks.edit'))
                    ->required(),

                Relation::make('task.user_id')
                    ->title('Сотрудник')
                    ->fromModel(User::class, 'name')
                    ->displayAppend('fullName')
                    ->applyScope('employees')
                    ->searchColumns('name', 'last_name', 'middle_name', 'email')
                    ->chunk(30)
                    ->help('Вы можете найти сотрудника введя его электронную почту или имя в поиск')
                    ->canSee(Auth::user()->hasAccess('platform.tasks.edit'))
                    ->disabled(!Auth::user()->hasAccess('platform.tasks.edit'))
                    ->required(),

                DateTimer::make('task.deadline')
                    ->enableTime()
                    ->title('Крайний срок')
                    ->disabled(!Auth::user()->hasAccess('platform.tasks.edit'))
                    ->required(),

                Input::make('task.header')
                    ->title('Заголовок')
                    ->disabled(!Auth::user()->hasAccess('platform.tasks.edit'))
                    ->required(),

                Quill::make('task.description')
                    ->title('Описание')
                    ->readonly(! Auth::user()->hasAccess('platform.tasks.edit'))
                    ->required(),
            ]),
        ];
    }

    public function createOrUpdate(Request $request, Task $task)
    {
        $request->validate([
            'task.header' => 'required|between:0,128',
            'task.description' => 'required|between:0,2048'
        ]);
        $task->fill($request->task)->save();

        Toast::success('Задача успешно сохранена.');

        return redirect()->route('platform.tasks');
    }

    public function startTask(Task $task)
    {
        if (empty($task->start_date)) {
            $task->start_date = now();
            $toastMessage = 'Вы начали выполнение задачи.';
        } else {
            $task->end_date = null;
            $toastMessage = 'Вы продолжили выполнение задачи.';
        }
        $task->save();

        Toast::info($toastMessage);

        return redirect()->route('platform.tasks.edit', $task);
    }

    public function endTask(Task $task)
    {
        $task->end_date = now();
        $task->save();

        Toast::info('Вы завершили задачу.');

        return redirect()->route('platform.tasks.edit', $task);
    }

    public function delete(Task $task)
    {
        $task->delete();

        Toast::success('Задача успешно удалена.');

        return redirect()->route('platform.tasks');
    }

    public function permission(): ?iterable
    {
        return [
            'platform.tasks',
            'platform.tasks.edit'
        ];
    }
}
