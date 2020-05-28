<?php

namespace Zareismail\RealEstate\Nova;
  
use Illuminate\Http\Request; 
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;    

class Uses extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'Zareismail\\RealEstate\\RealEstateUse';  

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return static::label();
    }

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

            Text::make(__("Uses of the property"), "name")
                ->required()
                ->rules("required"),   

            Text::make(__("Help"), "help")
                ->nullable(),   
        ];
    } 
}
