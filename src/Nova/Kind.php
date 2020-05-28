<?php

namespace Zareismail\RealEstate\Nova;
  
use Illuminate\Http\Request; 
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;   
use Armincms\Fields\BelongsToMany;

class Kind extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'Zareismail\\RealEstate\\RealEstateKind'; 

    /**
     * The relationships that should be eager loaded when performing an index query.
     *
     * @var array
     */
    public static $with = [
        'metadatas'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return[
            ID::make("ID")->sortable(),   

            Text::make(__("Property Kind"), "name")
                ->required()
                ->rules("required"), 

            BelongsToMany::make(__("Required Amenities"), "metadatas", Amenity::class)
                ->fillUsing(function($pivots) { 
                    return ['has_metadata_type' => (new static::$model)->getMorphClass()];
                }), 
        ];
    } 
}
