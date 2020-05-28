<?php

namespace Zareismail\RealEstate;

use Zareismail\NovaContracts\User; 

class Employee extends User 
{    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * Get the default foreign key name for the model.
     *
     * @return string
     */
    public function getForeignKey()
    {
        return 'user_'.$this->getKeyName();
    }

    /**
     * Determine if this resource is available for navigation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    public static function availableForNavigation(Request $request)
    { 
        return $request->user()->load(['roles' => function($q) {
            $q->where($q->qualifyColumn('id'), RealEstate::option('_rs_manager_'));
        }])->roles->isNotEmpty();
    }
}
