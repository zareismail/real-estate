<?php

namespace Zareismail\RealEstate;
 
use Illuminate\Foundation\Auth\User;


class Helper 
{     
    /**
     * Get a list of agencies that user serve for it.
     *
     * @return string
     */
    public static function userRelatedAgencies(User $user)
    {
        return RealEstateAgency::authenticate($user)
                ->orWhereHas('auth', function($q) use ($user) {
                    $user->relationLoaded('employers') || $user->load('employers');
                    // If the employers are owners
                    $q->whereIn(
                        $q->qualifyColumn('id'), $user->employers()->get()->modelKeys()
                    );
                })
                ->get();
    }

    /**
     * Add a user to the agency customers list.
     *
     * @return string
     */
    public static function addAgencyCustomer(RealEstateAgency $agency, User $user)
    {
        $agency->relationLoaded('auth') || $agency->load('auth');

        return $agency->auth->customers()->syncWithoutDetaching($user);
    }
}
