<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Orchid\Support\Facades\Dashboard;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Role>
 */
class RoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'slug' => fake()->unique()->numerify('role ###'),
            'name' => fake()->unique()->numerify('role ###'),
        ];
    }

    /**
     * Define the CEO role
     *
     * @return RoleFactory
     */
    public function ceo()
    {
        return $this->state(
            fn (array $attributes) => [
                'name' => 'Директор',
                'slug' => 'ceo',
                'permissions' => Dashboard::getAllowAllPermission(),
            ]
        );
    }

    /**
     * Define the CIO role
     *
     * @return RoleFactory
     */
    public function cio()
    {
        return $this->state(
            fn (array $attributes) => [
                'name' => 'IT-директор',
                'slug' => 'cio',
                'permissions' => Dashboard::getAllowAllPermission(['Основное', 'Повышенные полномочия', 'Хранилище']),
            ]
        );
    }

    /**
     * Define the manager role
     *
     * @return RoleFactory
     */
    public function manager()
    {
        return $this->state(
            fn (array $attributes) => [
                'name' => 'Менеджер',
                'slug' => 'manager',
                'permissions' => Dashboard::getAllowAllPermission(['Основное', 'Работа с клиентами', 'Повышенные полномочия']),
            ]
        );
    }

    /**
     * Define the agent role
     *
     * @return RoleFactory
     */
    public function agent()
    {
        return $this->state(
            fn (array $attributes) => [
                'name' => 'Агент',
                'slug' => 'agent',
                'permissions' => Dashboard::getAllowAllPermission(['Основное', 'Работа с клиентами']),
            ]
        );
    }

    /**
     * Define the High Level Developer role
     *
     * @return RoleFactory
     */
    public function hlDev()
    {
        return $this->state(
            fn (array $attributes) => [
                'name' => 'Старший разработчик',
                'slug' => 'hl_dev',
                'permissions' => Dashboard::getAllowAllPermission(['Основное', 'Повышенные полномочия']),
            ]
        );
    }

    /**
     * Define the Developer role
     *
     * @return RoleFactory
     */
    public function dev()
    {
        return $this->state(
            fn (array $attributes) => [
                'name' => 'Разработчик',
                'slug' => 'dev',
                'permissions' => Dashboard::getAllowAllPermission(['Основное']),
            ]
        );
    }

    /**
     * Define the customer role
     *
     * @return RoleFactory
     */
    public function customer()
    {
        return $this->state(
            fn (array $attributes) => ['name' => 'Заказчик', 'slug' => 'customer']
        );
    }
}
