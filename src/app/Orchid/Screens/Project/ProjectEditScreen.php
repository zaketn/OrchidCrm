<?php

namespace App\Orchid\Screens\Project;

use App\Models\Project;
use App\Models\User;
use App\Orchid\Layouts\Project\EmployeesRolesByProject;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ProjectEditScreen extends Screen
{
    public Project $project;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Project $project): iterable
    {
        return [
            'project' => $project,
            'employeesByProjectChart' => [
                [
                    'name' => 'Сотрудники по должностям',
                    'labels' => $project->getRoleNamesOfTeam(),
                    'values' => $project->countTeamMembersByRole(),
                ]
            ],
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->project->exists ? 'Проект #' . $this->project->id : 'Новый проект';
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
                ->canSee($this->project->exists)
                ->confirm('Вы действительно хотите удалить проект?')
                ->icon('trash'),

            Button::make($this->project->exists ? 'Редактировать' : 'Создать')
                ->method('createOrUpdate')
                ->confirm('Вы действительно хотите обновить данные проекта?')
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
        $layout = [
            Layout::rows([
                Input::make('project.name')
                    ->title('Название')
                    ->required(),

                Select::make('project.status')
                    ->title('Статус')
                    ->options([
                        Project::STATUS_STARTED => 'В разработке',
                        Project::STATUS_STOPPED => 'Приостановлен',
                        Project::STATUS_FINISHED => 'Завершен',
                        Project::STATUS_CANCELLED => 'Отменен',
                    ])
                    ->required()
                    ->canSee($this->project->exists),

                Relation::make('project.customers')
                    ->title('Заказчики')
                    ->fromModel(User::class, 'name')
                    ->displayAppend('fullName')
                    ->applyScope('customers')
                    ->chunk(50)
                    ->multiple()
                    ->required(),

                Relation::make('project.employees')
                    ->title('Команда')
                    ->fromModel(User::class, 'name')
                    ->displayAppend('fullName')
                    ->applyScope('employees')
                    ->chunk(50)
                    ->multiple()
                    ->required(),

                Input::make('project.repo_link')
                    ->title('Ссылка на репозиторий')
                    ->required(),

                Upload::make($this->project->exists ? 'project.contract' : 'upload')
                    ->maxFiles(1)
                    ->acceptedFiles('application/pdf')
                    ->title('Договор')
            ]),
        ];

        if($this->project->exists)
            $layout[] = EmployeesRolesByProject::class;

        return $layout;
    }

    public function createOrUpdate(Project $project, Request $request)
    {
//    TODO validate unique fields
        $request->validate([
            'project.name' => 'required|string|between:1,64',
            'project.repo_link' => 'required|between:1,128',
            'project.employees' => 'required|exists:users,id',
            'project.customers' => 'required|exists:users,id',
        ]);

        $projectUsers = array_merge($request->project['customers'], $request->project['employees']);
        $contractInput = $project->exists ? 'project.contract' : 'upload';

        $project->fill($request->project);
        $project->contract = $request->input($contractInput)[0];
        $project->save();

        $project->users()->sync($projectUsers);

        $project->attachment()->syncWithoutDetaching(
            $request->input($contractInput, [])
        );

        Toast::success('Успешно!');

        return redirect()->route('platform.projects.edit', $project);
    }

    public function delete(Project $project)
    {
        $project->users()->detach();

        $project->delete();

        Toast::success('Проект #' . $project->id . ' успешно удален.');

        return redirect()->route('platform.projects');
    }
}
