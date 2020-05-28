<?php

namespace Zareismail\RealEstate;

use Zareismail\NovaContracts\User; 

class Customer extends User 
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
}
