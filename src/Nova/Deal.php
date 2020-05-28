<?php

namespace Zareismail\RealEstate\Nova;
  
use Illuminate\Http\Request; 
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;   
use Laravel\Nova\Fields\Select;   
use OwenMelbz\RadioField\RadioButton;

class Deal extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'Zareismail\\RealEstate\\RealEstateDeal';  

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

            Text::make(__("Type of the property deal"), "name")
                ->required()
                ->rules("required"), 

            Text::make(__("Supply Label"), "supply")
                ->help(__("This label displayed to suppliers")), 

            Text::make(__("Demand Label"), "demand")
                ->help(__("This label displayed to demanders")),   

            RadioButton::make(__("Pricing Method"), "pricing")
                ->options($pricings = static::$model::pricings())
                ->required()
                ->rules("required")
                ->toggle([
                    'certain' => ['period'],
                    'adaptive'=> ['period'],
                ])
                ->default('certain'),  

            Select::make(__("Pricing Period"), "period")
                ->options(static::$model::periods())
                ->displayUsingLabels()
                ->required()
                ->default('month'),  
        ];
    } 
}
