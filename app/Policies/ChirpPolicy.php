<?php

namespace App\Policies;

use App\Models\Chirp;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ChirpPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Chirp $chirp): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Chirp $chirp): bool
    {
        // This method is used to determine if the user can update an existing Chirp model.
        // It checks if the user attempting to update the Chirp is the owner of the Chirp.
        // If the user is the owner, access is granted; otherwise, access is denied.
        return $chirp->user()->is($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Chirp $chirp): bool
    {
        // This method determines if the user can delete a Chirp model.
        // It delegates the authorization logic to the update method.
        // This is often done because deleting a model typically requires the same permissions as updating it.
        // So, if the user can update the Chirp (which means they are the owner), they can also delete it.
        return $this->update($user, $chirp);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Chirp $chirp): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Chirp $chirp): bool
    {
        //
    }
}
