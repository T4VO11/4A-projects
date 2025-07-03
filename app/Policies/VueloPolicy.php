<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Vuelo;

class VueloPolicy
{

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Vuelo $vuelo): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }
    public function update(User $user, Vuelo $vuelo): bool
    {
        return $user->role === 'admin';
    }
    public function delete(User $user, Vuelo $vuelo): bool
    {
        return $user->role === 'admin';
    }
}