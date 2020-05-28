<?php

namespace Zareismail\RealEstate\Policies;

use Zareismail\RealEstate\RealEstateAgency as Agency;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Contracts\Auth\Authenticatable;

class RealEstateAgency
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
        return true;
    }

    /**
     * Determine whether the user can view the policy role.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  \Zareismail\RealEstate\RealEstateAgency  $agency
     * @return mixed
     */
    public function view(Authenticatable $user, Agency $agency)
    {
        return true;
    }

    /**
     * Determine whether the user can create policy roles.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @return mixed
     */
    public function create(Authenticatable $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the policy role.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  \Zareismail\RealEstate\RealEstateAgency  $agency
     * @return mixed
     */
    public function update(Authenticatable $user, Agency $agency)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the policy role.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  \Zareismail\RealEstate\RealEstateAgency  $agency
     * @return mixed
     */
    public function delete(Authenticatable $user, Agency $agency)
    {
        return true;
    }

    /**
     * Determine whether the user can restore the policy role.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  \Zareismail\RealEstate\RealEstateAgency  $agency
     * @return mixed
     */
    public function restore(Authenticatable $user, Agency $agency)
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the policy role.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  \Zareismail\RealEstate\RealEstateAgency  $agency
     * @return mixed
     */
    public function forceDelete(Authenticatable $user, Agency $agency)
    {
        return true;
    } 

    /**
     * Determine whether the user can add location to the agency.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  \Zareismail\RealEstate\RealEstateAgency  $agency
     * @return mixed
     */
    public function addLocation(Authenticatable $user)
    {
        return true;
    }

    /**
     * Determine whether the user can add location to the agency.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  \Zareismail\RealEstate\RealEstateAgency  $agency
     * @return mixed
     */
    public function addUser(Authenticatable $user)
    {
        return true;
    }

    /**
     * Determine whether the user can add location to the agency.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  \Zareismail\RealEstate\RealEstateAgency  $agency
     * @return mixed
     */
    public function addManager(Authenticatable $user)
    {
        return true;
    }
}
