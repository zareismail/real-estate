<?php

namespace Zareismail\RealEstate\Nova;

use Armincms\Bios\Resource;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;
use Zareismail\NovaPolicy\PolicyRole;

class RealEstate extends Resource
{  
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'Zareismail\\RealEstate\\Option'; 

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [ 
            Select::make(__('Manager Related Role'), '_rs_manager_')
                ->options(PolicyRole::get()->pluck('name', 'id'))
                ->displayUsingLabels()
                ->required()
                ->rules('required'),

            Select::make(__('Employee Related Role'), '_rs_employee_')
                ->options(PolicyRole::get()->pluck('name', 'id'))
                ->displayUsingLabels()
                ->required()
                ->rules('required'),

            Select::make(__('Customer Related Role'), '_rs_customer_')
                ->options(PolicyRole::get()->pluck('name', 'id'))
                ->displayUsingLabels()
                ->required()
                ->rules('required'),
        ];
    }
}
