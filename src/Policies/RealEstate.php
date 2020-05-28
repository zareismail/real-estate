<?php 

namespace Zareismail\RealEstate\Policies;

use Zareismail\RealEstate\Option;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Contracts\Auth\Authenticatable;

class RealEstate
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
     * @param  \Armincms\Bios\Option  $option
     * @return mixed
     */
    public function view(Authenticatable $user, Option $option)
    {
        return true;
    }
 
    /**
     * Determine whether the user can update the policy role.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  \Armincms\Bios\Option  $option
     * @return mixed
     */
    public function update(Authenticatable $user, Option $option)
    {
        return true;
    } 
}
