<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Hotel;

class HotelPolicy
{

    public function viewAny(User $user): bool
    {
        return true; // Todos pueden ver la lista de hoteles
    }

    public function view(User $user, Hotel $hotel): bool
    {
        return true; // Todos pueden ver los detalles de un hotel
    }

//roles de admins

    public function create(User $user): bool
    {
        return $user->role === 'admin'; // Solo admins pueden crear hoteles
    }

    public function update(User $user, Hotel $hotel): bool
    {
        return $user->role === 'admin'; // Solo admins pueden actualizar hoteles
    }

    public function delete(User $user, Hotel $hotel): bool
    {
        return $user->role === 'admin'; // Solo admins pueden eliminar hoteles
    }
        public function restore(User $user, Hotel $hotel): bool
    {
        return $user->role === 'admin';
    }
}