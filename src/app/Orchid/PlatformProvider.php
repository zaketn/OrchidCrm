<?php

declare(strict_types=1);

namespace App\Orchid;

use App\Models\Lead;
use Illuminate\Support\Facades\Auth;
use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Actions\Menu;

class PlatformProvider extends OrchidServiceProvider
{
    /**
     * @param Dashboard $dashboard
     */
    public function boot(Dashboard $dashboard): void
    {
        parent::boot($dashboard);

        Dashboard::useModel(\Orchid\Platform\Models\Role::class, \App\Models\Role::class);
    }

    /**
     * @return Menu[]
     */
    public function registerMainMenu(): array
    {
        return [
            Menu::make('Главная')
                ->icon('grid')
                ->active('false')
                ->route('platform.index'),

            Menu::make('Сайт')
                ->icon('arrow-left-circle')
                ->active('false')
                ->route('index')
                ->target('_blank'),

            Menu::make('Заявки')
                ->icon('envelope')
                ->route('platform.leads', ['filter' => ['status' => [Lead::STATUS_PENDING]]])
                ->permission(['platform.leads', 'platform.leads.edit'])
                ->title('Работа с клиентами'),

            Menu::make('Встречи')
                ->icon('event')
                ->route('platform.meetups')
                ->permission(['platform.meetups', 'platform.meetups.edit']),

            Menu::make('Задачи')
                ->icon('task')
                ->route(
                    'platform.tasks',
                    Auth::user()->hasAccess('platform.tasks.edit')
                        ? ['filter' => ['user_id' => Auth::id()]]
                        : null
                )
                ->permission('platform.tasks')
                ->title('Работа'),

            Menu::make('Проекты')
                ->icon('docs')
                ->route('platform.projects')
                ->permission('platform.projects')
                ->title('Проекты'),

            Menu::make(__('Users'))
                ->icon('user')
                ->route('platform.systems.users')
                ->permission('platform.systems.users')
                ->title(__('Access rights')),

            Menu::make(__('Roles'))
                ->icon('lock')
                ->route('platform.systems.roles')
                ->permission('platform.systems.roles'),
        ];
    }

    /**
     * @return Menu[]
     */
    public function registerProfileMenu(): array
    {
        return [
            Menu::make('Profile')
                ->route('platform.profile')
                ->icon('user'),
        ];
    }

    /**
     * @return ItemPermission[]
     */
    public function registerPermissions(): array
    {
        return [
            ItemPermission::group(__('System'))
                ->addPermission('platform.systems.roles', __('Roles'))
                ->addPermission('platform.systems.users', __('Users')),

            ItemPermission::group('Основное')
                ->addPermission('platform.meetups', 'Просмотр встреч')
                ->addPermission('platform.tasks', 'Доступ к задачам'),

            ItemPermission::group('Работа с клиентами')
                ->addPermission('platform.leads', 'Просмотр заявок')
                ->addPermission('platform.leads.edit', 'Просмотр и управление заявками')
                ->addPermission('platform.meetups.edit', 'Просмотр и управление встречами'),

            ItemPermission::group('Повышенные полномочия')
                ->addPermission('platform.tasks.edit', 'Управление задачами')
                ->addPermission('platform.projects', 'Просмотр проектов'),

            ItemPermission::group('Хранилище')
                ->addPermission('platform.projects.edit', 'Управление проектами')
                ->addPermission('platform.contracts', 'Просмотр договоров')
                ->addPermission('platform.contracts.edit', 'Управление договорами'),
        ];
    }
}
