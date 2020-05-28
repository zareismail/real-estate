<?php

namespace Zareismail\RealEstate;

use Zareismail\MetaData\Metadata as Model;  

class Metadata extends Model 
{  
    /**
     * Get the class name of the parent model.
     *
     * @return string
     */
    public function getMorphClass()
    {
        return parent::class;
    }
}
