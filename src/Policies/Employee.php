<?php

namespace Zareismail\RealEstate\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Contracts\Auth\Authenticatable; 

class Employee
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any policy roles.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @return mixed
     */
    public function viewAny(Authenticatable $user)
    {
        //
    }

    /**
     * Determine whether the user can view the policy role.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $employee
     * @return mixed
     */
    public function view(Authenticatable $user, Authenticatable $employee)
    {
        //
    }

    /**
     * Determine whether the user can create policy roles.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @return mixed
     */
    public function create(Authenticatable $user)
    {
        //
    }

    /**
     * Determine whether the user can update the policy role.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $employee
     * @return mixed
     */
    public function update(Authenticatable $user, Authenticatable $employee)
    {
        //
    } 
}
