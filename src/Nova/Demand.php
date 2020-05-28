<?php

namespace Zareismail\RealEstate\Nova;
  
use Illuminate\Http\Request; 
use Laravel\Nova\Panel;
use Laravel\Nova\Fields\ID;    
use Laravel\Nova\Fields\Text; 
use Laravel\Nova\Fields\Trix;   
use Laravel\Nova\Fields\Boolean;   
use Laravel\Nova\Fields\BelongsTo;         
use Armincms\Fields\BelongsToMany;
use Armincms\Fields\MorphToMany;
use Zareismail\NovaLocation\Nova\Settlement;
use Zareismail\NovaContracts\Nova\User;

class Demand extends Resource
{
    use Dealable;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'Zareismail\\RealEstate\\RealEstateDemand'; 

    /**
     * Determine if this resource is available for navigation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    public static function availableForNavigation(Request $request)
    { 
        return $request->user()->can('addModifier', static::newModel());
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

            BelongsTo::make(__("Modifier"), 'auth', User::class)
                ->withoutTrashed()
                ->required()
                ->rules('required')
                ->default($request->user())
                ->hideFromIndex()
                ->canSee(function($request) {
                    return $request->user()->can('addModifier', static::newModel());
                }),  

            BelongsTo::make(__("Applicant User"), 'applicant', User::class)
                ->withoutTrashed()
                ->required()
                ->rules('required'), 

            BelongsTo::make(__("Agency Agent"), 'agent', User::class)
                ->withoutTrashed()
                ->required()
                ->rules('required')
                ->default($request->user()), 

            BelongsToMany::make(__("Responsible Agencies"), 'agencies', Agency::class)
                ->withoutTrashed()
                ->required()
                ->rules('required')
                ->pivots()
                ->fields(function() {
                    return [
                        Boolean::make(__('Shared'), 'shared')
                            ->default(0)
                    ];
                }),

            BelongsToMany::make(__("Needed Property"), 'kinds', Kind::class)
                ->required()
                ->rules('required')
                ->fillUsing(function($pivots) {
                    return [
                        'kindable_type' => static::newModel()->getMorphClass()
                    ];
                }),     

            BelongsToMany::make(__("Needed Uses"), 'uses', Uses::class) 
                ->required()
                ->rules('required')
                ->fillUsing(function($pivots) {
                    return [
                        'usable_type' => static::newModel()->getMorphClass()
                    ];
                }), 

            $this->dealableField(),

            BelongsToMany::make(__("Appropriate Locations"), 'settlements', Settlement::class) 
                ->fillUsing(function($pivots) { 
                    return [
                        'locatable_type' => static::newModel()->getMorphClass()
                    ];
                }),

            Trix::make(__("Applicant Explanations"), 'explanation')
                ->nullable(),

            Trix::make(__("Agent Notes"), 'note')
                ->nullable(),  
        ];
    } 
}
