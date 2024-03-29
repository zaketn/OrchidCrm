<?php

declare(strict_types=1);

namespace App\Orchid\Presenters;

use Illuminate\Support\Str;
use Laravel\Scout\Builder;
use Orchid\Screen\Contracts\Personable;
use Orchid\Screen\Contracts\Searchable;
use Orchid\Support\Presenter;

class UserPresenter extends Presenter implements Searchable, Personable
{
    /**
     * @return string
     */
    public function label(): string
    {
        return 'Users';
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->fullName();
    }

    /**
     * Return user roles dashed with /
     *
     * @return string
     */
    public function subTitle(): string
    {
        $roles = $this->entity->roles->pluck('name')->implode(' / ');

        return (string)Str::of($roles)
            ->limit(20)
            ->whenEmpty(function () {
                return __('Regular user');
            });
    }

    /**
     * @return string
     */
    public function url(): string
    {
        return route('platform.systems.users.edit', $this->entity);
    }

    /**
     * @return string
     */
    public function image(): ?string
    {
        $hash = md5(strtolower(trim($this->entity->email)));

        return "https://www.gravatar.com/avatar/$hash?d=mp";
    }

    /**
     * The number of models to return for show compact search result.
     *
     * @return int
     */
    public function perSearchShow(): int
    {
        return 3;
    }

    /**
     * @param string|null $query
     *
     * @return Builder
     */
    public function searchQuery(string $query = null): Builder
    {
        return $this->entity->search($query);
    }

    /**
     * Returns person's full name
     *
     * @return string
     */
    public function fullName(): string
    {
        return $this->entity->last_name . ' ' . $this->entity->name . ' ' . $this->entity->middle_name;
    }
}
