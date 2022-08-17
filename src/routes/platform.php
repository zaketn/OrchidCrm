<?php

declare(strict_types=1);

use App\Orchid\Screens\Lead\LeadEditScreen;
use App\Orchid\Screens\Lead\LeadListScreen;
use App\Orchid\Screens\Meetup\MeetupEditScreen;
use App\Orchid\Screens\Meetup\MeetupListScreen;
use App\Orchid\Screens\PlatformScreen;
use App\Orchid\Screens\Project\ProjectEditScreen;
use App\Orchid\Screens\Project\ProjectListScreen;
use App\Orchid\Screens\Role\RoleEditScreen;
use App\Orchid\Screens\Role\RoleListScreen;
use App\Orchid\Screens\Task\TaskEditScreen;
use App\Orchid\Screens\Task\TaskListScreen;
use App\Orchid\Screens\User\UserEditScreen;
use App\Orchid\Screens\User\UserListScreen;
use App\Orchid\Screens\User\UserProfileScreen;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the need "dashboard" middleware group. Now create something great!
|
*/

// Main
Route::screen('/main', PlatformScreen::class)
    ->name('platform.main');

// Platform > Profile
Route::screen('profile', UserProfileScreen::class)
    ->name('platform.profile')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Profile'), route('platform.profile'));
    });

// Platform > System > Users
Route::screen('users/{user}/edit', UserEditScreen::class)
    ->name('platform.systems.users.edit')
    ->breadcrumbs(function (Trail $trail, $user) {
        return $trail
            ->parent('platform.systems.users')
            ->push(__('User'), route('platform.systems.users.edit', $user));
    });

// Platform > System > Users > Create
Route::screen('users/create', UserEditScreen::class)
    ->name('platform.systems.users.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.systems.users')
            ->push(__('Create'), route('platform.systems.users.create'));
    });

// Platform > System > Users > User
Route::screen('users', UserListScreen::class)
    ->name('platform.systems.users')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Users'), route('platform.systems.users'));
    });

// Platform > System > Roles > Role
Route::screen('roles/{role}/edit', RoleEditScreen::class)
    ->name('platform.systems.roles.edit')
    ->breadcrumbs(function (Trail $trail, $role) {
        return $trail
            ->parent('platform.systems.roles')
            ->push(__('Role'), route('platform.systems.roles.edit', $role));
    });

// Platform > System > Roles > Create
Route::screen('roles/create', RoleEditScreen::class)
    ->name('platform.systems.roles.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.systems.roles')
            ->push(__('Create'), route('platform.systems.roles.create'));
    });

// Platform > System > Roles
Route::screen('roles', RoleListScreen::class)
    ->name('platform.systems.roles')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Roles'), route('platform.systems.roles'));
    });

Route::screen('leads', LeadListScreen::class)
    ->name('platform.leads')
    ->breadcrumbs(
        fn(Trail $trail) => $trail
            ->parent('platform.index')
            ->push('Заявки', route('platform.leads'))
    );

Route::screen('leads/{lead}', LeadEditScreen::class)
    ->name('platform.leads.edit')
    ->breadcrumbs(
        fn(Trail $trail) => $trail
            ->parent('platform.leads')
            ->push('Заявка')
    );

Route::screen('meetups', MeetupListScreen::class)
    ->name('platform.meetups')
    ->breadcrumbs(
        fn(Trail $trail) => $trail
            ->parent('platform.index')
            ->push('Встречи', route('platform.meetups'))
    );

Route::screen('meetup/{meetup?}', MeetupEditScreen::class)
    ->name('platform.meetups.edit')
    ->breadcrumbs(
        fn(Trail $trail) => $trail
            ->parent('platform.meetups')
            ->push('Встреча', route('platform.meetups.edit'))
    );

Route::screen('tasks', TaskListScreen::class)
    ->name('platform.tasks')
    ->breadcrumbs(
        fn(Trail $trail) => $trail
            ->parent('platform.index')
            ->push('Задачи', route('platform.tasks'))
    );

Route::screen('task/{task?}', TaskEditScreen::class)
    ->name('platform.tasks.edit')
    ->breadcrumbs(
        fn(Trail $trail) => $trail
            ->parent('platform.tasks')
            ->push('Задача', route('platform.tasks.edit'))
    );

Route::screen('projects', ProjectListScreen::class)
    ->name('platform.projects')
    ->breadcrumbs(
        fn(Trail $trail) => $trail
            ->parent('platform.index')
            ->push('Проекты', 'platform.projects')
    );

Route::screen('project/{project?}', ProjectEditScreen::class)
    ->name('platform.projects.edit')
    ->breadcrumbs(
        fn(Trail $trail) => $trail
            ->parent('platform.projects')
            ->push('Изменение проекта', 'platform.projects.edit')
    );
