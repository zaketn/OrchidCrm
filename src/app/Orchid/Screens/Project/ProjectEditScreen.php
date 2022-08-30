<?php

namespace App\Orchid\Screens\Project;

use App\Models\Project;
use App\Models\User;
use App\Notifications\InvitingToProject;
use App\Orchid\Layouts\Project\EmployeesRolesByProject;
use App\Orchid\Layouts\Project\TasksStatusesByProject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
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
        $layout =  [
            'project' => $project,
        ];

        if($project->exists){
            $layout['metrics'] = [
                'status' => $project->presenter()->localizedStatus(),
                'teamAmount' => $project->employees()->count(),
                'customerCompany' => $project->customers()->first()->company()->first()->name
            ];

            $layout['charts'] = [
                'employeesByProjectChart' => [
                    [
                        'name' => 'Сотрудники по должностям',
                        'labels' => $project->getRoleNamesOfTeam(),
                        'values' => $project->countTeamMembersByRole(),
                    ]
                ],
                'tasksStatusesByProjectChart' => [
                    [
                        'name' => 'Выполнение задач',
                        'labels' => $project->getStatusesOfRelatedTasks(),
                        'values' => $project->countTasksByStatus(),
                    ]
                ],
            ];
        }

        return $layout;
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
        $commandBar = [
            Button::make('Удалить')
                ->method('delete')
                ->canSee($this->project->exists)
                ->confirm('Вы действительно хотите удалить проект?')
                ->icon('trash'),

            Button::make($this->project->exists ? 'Сохранить' : 'Создать')
                ->method('createOrUpdate')
                ->confirm('Вы действительно хотите обновить данные проекта?')
                ->icon('pencil'),
        ];

        if ($contract = $this->project->attachment()->first())
            array_unshift($commandBar,
                Link::make('Договор')
                    ->href($contract->url())
                    ->target('_blank')
                    ->icon('doc'),

                Link::make('Репозиторий')
                    ->href($this->project->repo_link)
                    ->target('_blank')
                    ->icon('social-github'),
            );

        return $commandBar;
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
            ])
                ->canSee(Auth::user()->hasAccess('platform.projects.edit')),
        ];

        if ($this->project->exists)
            array_unshift($layout,
                Layout::metrics([
                    'Статус' => 'metrics.status',
                    'Размер команды' => 'metrics.teamAmount',
                    'Компания заказчика' => 'metrics.customerCompany'
                ]),

                Layout::columns([
                    EmployeesRolesByProject::class,
                    TasksStatusesByProject::class,
                ]));

        return $layout;
    }

    public function createOrUpdate(Project $project, Request $request)
    {
        $request->validate([
            'project.name' => 'required|string|between:1,64',
            'project.repo_link' => 'required|between:1,128',
            'project.employees' => 'required|exists:users,id',
            'project.customers' => 'required|exists:users,id',
        ]);

        $projectUsers = array_merge($request->project['customers'], $request->project['employees']);
        $newProjectUsers = collect($projectUsers)->diff($project->users->pluck('id'));
        $contractInput = $project->exists ? 'project.contract' : 'upload';

        $project->fill($request->project);
        if(isset($request->input($contractInput)[0])){
            $project->contract = $request->input($contractInput)[0];
        }
        $project->save();

        $project->users()->sync($projectUsers);

        $project->attachment()->syncWithoutDetaching(
            $request->input($contractInput, [])
        );

        Notification::send(User::whereIn('id', $newProjectUsers)->get(), (new InvitingToProject($project)));
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
