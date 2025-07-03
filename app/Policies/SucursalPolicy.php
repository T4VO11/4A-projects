<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Sucursal;
use Illuminate\Auth\Access\Response;

class SucursalPolicy
{

    public function viewAny(User $user): bool
    {
        return true; // Todos pueden ver la lista de sucursales
    }

    public function view(User $user, Sucursal $sucursal): bool
    {
        return true; // Todos pueden ver los detalles de una sucursal
    }

    //roles admins

    public function create(User $user): bool
    {
        return $user->role === 'admin'; // Solo admins pueden crear sucursales
    }

    public function update(User $user, Sucursal $sucursal): bool
    {
        return $user->role === 'admin'; // Solo admins pueden actualizar sucursales
    }

    public function delete(User $user, Sucursal $sucursal): bool
    {
        return $user->role === 'admin'; // Solo admins pueden eliminar/ocultar sucursales
    }

    public function restore(User $user, Sucursal $sucursal): bool
    {
        return $user->role === 'admin';
    }
}