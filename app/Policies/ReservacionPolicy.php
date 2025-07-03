<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Reservacion;
use Illuminate\Auth\Access\Response; 

class ReservacionPolicy
{

    public function viewAny(User $user): bool
    {

        return true;
    }


    public function view(User $user, Reservacion $reservacion): bool
    {
        return $user->id === $reservacion->idUsuarioFK || $user->role === 'admin';
    }


    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Reservacion $reservacion): bool
    {
        return $user->id === $reservacion->idUsuarioFK || $user->role === 'admin';
    }

    public function delete(User $user, Reservacion $reservacion): bool
    {
        return $user->id === $reservacion->idUsuarioFK || $user->role === 'admin';
    }
}