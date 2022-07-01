<?php

namespace App\Orchid\Screens\Task;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Orchid\Support\Facades\Alert;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

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
            'task' => $task
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
                ->canSee($this->task->exists)
                ->icon('trash'),

            Button::make('Обновить задачу')
                ->method('createOrUpdate')
                ->canSee($this->task->exists)
                ->icon('pencil'),

            Button::make('Создать задачу')
                ->method('createOrUpdate')
                ->canSee(!$this->task->exists)
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
        /*
         * TODO user full name display
         * TODO modal when delete task
         */

        return [
            Layout::rows([
                Relation::make('task.project_id')
                    ->title('Проект')
                    ->fromModel(Project::class, 'name')
                    ->searchColumns('name', 'repo_link')
                    ->chunk(30)
                    ->help('Вы можете найти проект введя его название или ссылку на репозиторий в поиск')
                    ->required(),

                Relation::make('task.user_id')
                    ->title('Сотрудник')
                    ->fromModel(User::class, 'name')
                    ->displayAppend('fullNameWithRoles')
                    ->searchColumns('name', 'last_name', 'middle_name', 'email')
                    ->chunk(30)
                    ->help('Вы можете найти сотрудника введя его электронную почту или имя в поиск')
                    ->required(),

                Input::make('task.header')
                    ->title('Заголовок')
                    ->required(),

                Quill::make('task.description')
                    ->title('Описание')
                    ->required(),

                Input::make('task.hours')
                    ->type('number')
                    ->min(1)
                    ->max(100)
                    ->step(0.5)
                    ->title('Время на выполнения')
                    ->help('В часах')
                    ->required(),
            ])
        ];
    }

    public function createOrUpdate(Request $request, Task $task)
    {
        $task->fill($request->task)->save();

        Alert::info('Успешно');

        return redirect()->route('platform.tasks');
    }

    public function delete(Task $task)
    {
        $task->delete();

        Alert::info('Задача успешно удалена');

        return redirect()->route('platform.tasks');
    }
}
