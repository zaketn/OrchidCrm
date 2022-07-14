<?php

declare(strict_types=1);

namespace App\Orchid;

use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\Models\Role;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Actions\Menu;
use Orchid\Support\Color;

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
            Menu::make('Заявки')
                ->icon('envelope')
                ->route('platform.leads')
                ->permission(['platform.leads', 'platform.leads.edit'])
                ->title('Работа с клиентами'),

            Menu::make('Встречи')
                ->icon('event')
                ->route('platform.meetups')
                ->permission(['platform.meetups', 'platform.meetups.edit']),

            Menu::make('Все задачи')
                ->icon('book-open')
                ->route('platform.tasks')
                ->title('Задачи'),

            Menu::make('Создать задачу')
                ->icon('pencil')
                ->route('platform.tasks.edit'),

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

            ItemPermission::group('Работа с клиентами')
                ->addPermission('platform.leads','Просмотр заявок')
                ->addPermission('platform.leads.edit','Просмотр и управление заявками')
                ->addPermission('platform.meetups', 'Просмотр встреч')
                ->addPermission('platform.meetups.edit', 'Просмотр и управление встречами'),
        ];
    }
}
