<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param \App\User $user
     *
     * @return mixed
     */
    public function viewAny(User $user)
    {
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\User $user
     * @param \App\User $model
     *
     * @return mixed
     */
    public function view(User $user, User $model)
    {
        return ($user->hasRole('super')) || $user->can('read users') && $user->tenant_id === $model->tenant_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\User $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return ($user->hasRole('super')) || $user->can('create users');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\User $user
     * @param \App\User $model
     *
     * @return mixed
     */
    public function update(User $user, User $model)
    {
        return ($user->hasRole('super')) || $user->can('update users') && $user->tenant_id === $model->tenant_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\User $user
     * @param \App\User $model
     *
     * @return mixed
     */
    public function delete(User $user, User $model)
    {
        return ($user->hasRole('super')) || $user->can('delete users') && $user->tenant_id === $model->tenant_id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\User $user
     * @param \App\User $model
     *
     * @return mixed
     */
    public function restore(User $user, User $model)
    {
        return ($user->hasRole('super')) || $user->can('delete users') && $user->tenant_id === $model->tenant_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\User $user
     * @param \App\User $model
     *
     * @return mixed
     */
    public function forceDelete(User $user, User $model)
    {
        return ($user->hasRole('super')) || $user->can('delete users') && $user->tenant_id === $model->tenant_id;
    }
}
