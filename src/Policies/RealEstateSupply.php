<?php

namespace Zareismail\RealEstate\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Contracts\Auth\Authenticatable;
use Zareismail\RealEstate\RealEstateRequest; 

class RealEstateSupply
{
    use HandlesAuthorization; 

    /**
     * Determine whether the user can permanently delete the policy role.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  \Zareismail\RealEstate\RealEstateRequest  $supply
     * @return mixed
     */
    public function addModifier(Authenticatable $user)
    {
        //
    } 

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
     * @param  \Zareismail\RealEstate\RealEstateRequest  $supply
     * @return mixed
     */
    public function view(Authenticatable $user, RealEstateRequest $supply)
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
     * @param  \Zareismail\RealEstate\RealEstateRequest  $supply
     * @return mixed
     */
    public function update(Authenticatable $user, RealEstateRequest $supply)
    {
        //
    }

    /**
     * Determine whether the user can delete the policy role.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  \Zareismail\RealEstate\RealEstateRequest  $supply
     * @return mixed
     */
    public function delete(Authenticatable $user, RealEstateRequest $supply)
    {
        //
    }

    /**
     * Determine whether the user can restore the policy role.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  \Zareismail\RealEstate\RealEstateRequest  $supply
     * @return mixed
     */
    public function restore(Authenticatable $user, RealEstateRequest $supply)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the policy role.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  \Zareismail\RealEstate\RealEstateRequest  $supply
     * @return mixed
     */
    public function forceDelete(Authenticatable $user, RealEstateRequest $supply)
    {
        //
    }    
}
