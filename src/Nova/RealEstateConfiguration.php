<?php

namespace Zareismail\RealEstate\Nova;
   
use Illuminate\Http\Request;  

class RealEstateConfiguration extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'Zareismail\\RealEstate\\Option';   
    

    /**
     * Indicates if the resource should be displayed in the sidebar.
     *
     * @var bool
     */
    public static $displayInNavigation = false;

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [ 
        ];
    } 
}
