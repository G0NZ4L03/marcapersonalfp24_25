<?php

namespace App\Policies;

use App\Models\Idiomas;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class IdiomaPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool
    {
        //Añado interrogante haciendo que el user sea opcional y
        //devuelvo true para que cualquier usuario pueda ver las familias profesionales
        //Habilitando asi la vista al usuario anonimo
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Idiomas $idiomas): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //Hago una comprobacion de que el user sea admin
        //llamando a este metodo del modelo de user
        return $user->esAdmin();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Idiomas $idiomas): bool
    {
        return $user->esAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Idiomas $idiomas): bool
    {
        return $user->esAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Idiomas $idiomas): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Idiomas $idiomas): bool
    {
        return false;
    }
}
