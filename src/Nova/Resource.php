<?php

namespace Zareismail\RealEstate\Nova;
 
use Zareismail\NovaContracts\Nova\Resource as NovaResource;  

abstract class Resource extends NovaResource
{    
    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        "name"
    ];

    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'RealEstate';   
}
