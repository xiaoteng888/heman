<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function update(User $current,User $user)
    {
       return $current->id == $user->id;
    }

    public function destroy(User $current,User $user)
    {
      return $current->is_admin && $current->id !== $user->id && !$user->is_admin;
    }

    public function follow(User $current,User $user)
    {
        return $current->id !== $user->id;
    }
}
