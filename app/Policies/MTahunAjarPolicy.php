<?php

namespace App\Policies;

use App\Models\MTahunAjar;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MTahunAjarPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // return $user->can('view-any MTahunAjar');
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, MTahunAjar $mTahunAjar): bool
    {
        // return $user->can('view MTahunAjar');
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // return $user->can('create MTahunAjar');
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, MTahunAjar $mTahunAjar): bool
    {
        // return $user->can('update MTahunAjar');
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, MTahunAjar $mTahunAjar): bool
    {
        // return $user->can('delete MTahunAjar');
        return true;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, MTahunAjar $mTahunAjar): bool
    {
        // return $user->can('restore MTahunAjar');
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, MTahunAjar $mTahunAjar): bool
    {
        // return $user->can('force-delete MTahunAjar');
        return true;
    }
}
