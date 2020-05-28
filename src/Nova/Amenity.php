<?php

namespace Zareismail\RealEstate\Nova;
  
use Zareismail\MetaData\Nova\Resource;
use Illuminate\Http\Request;

class Amenity extends Resource
{  
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'Zareismail\\RealEstate\\Metadata'; 

    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'RealEstate'; 

    public static function relatableResources() : array
    { 
    	return [
            Kind::class,
    		Deal::class,
    		Demand::class,
    	];
    } 

    /**
     * Determine if this resource is available for navigation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    public static function availableForNavigation(Request $request)
    {
        return $request->user()->can('create', static::newModel());
    }
}
