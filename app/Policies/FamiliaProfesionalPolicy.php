<?php

namespace App\Policies;

use App\Models\FamiliaProfesional;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class FamiliaProfesionalPolicy
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
    public function view(?User $user, FamiliaProfesional $familiaProfesional): bool
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
    public function update(User $user, FamiliaProfesional $familiaProfesional): bool
    {
        //Compruebo si el usuario es admin
        return $user->esAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, FamiliaProfesional $familiaProfesional): bool
    {
        return $user->esAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, FamiliaProfesional $familiaProfesional): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, FamiliaProfesional $familiaProfesional): bool
    {
        return false;
    }
}
