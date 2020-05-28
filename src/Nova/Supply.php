<?php

namespace Zareismail\RealEstate\Nova;
  
use Illuminate\Http\Request; 
use Laravel\Nova\Panel;
use Laravel\Nova\Fields\ID;    
use Laravel\Nova\Fields\Text;   
use Laravel\Nova\Fields\Trix;   
use Laravel\Nova\Fields\Boolean; 
use Laravel\Nova\Fields\Heading;    
use Laravel\Nova\Fields\BelongsTo;  
use Zareismail\NovaLocation\Nova\Settlement;
use Zareismail\NovaContracts\Nova\User;
use GeneaLabs\NovaMapMarkerField\MapMarker;   
use Armincms\Fields\BelongsToMany; 


class Supply extends Resource 
{
    use Dealable;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'Zareismail\\RealEstate\\RealEstateSupply';   

    /**
     * The relationships that should be eager loaded when performing an index query.
     *
     * @var array
     */
    public static $with = [
        'deals', 'applicant', 'agent', 'settlement', 'kind', 'uses', 'metadatas', 'shares', 'responsibles'
    ];

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
        return [ 
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

            BelongsTo::make(__("Property Location"), 'settlement', Settlement::class)
                ->withoutTrashed()
                ->required()
                ->rules('required'), 

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

            BelongsTo::make(__("Property Type"), 'kind', Kind::class)
                ->withoutTrashed()
                ->required()
                ->rules('required'), 

            BelongsTo::make(__("Uses of property"), 'uses', Uses::class)
                ->withoutTrashed()
                ->required()
                ->rules('required'), 

            $this->dealableField(),

            BelongsToMany::make(__("Property Amenities"), 'metadatas', Amenity::class)
                ->fields(function($request, $resource) {
                    $amenity = Amenity::$model::findOrFail($request->relatedId);

                    return [
                        tap($amenity->field::make($amenity->name, 'value'), function($field) use ($amenity) {
                            if($amenity->options) {
                                $field
                                    ->options($amenity->options)
                                    ->required()
                                    ->rules('required')
                                    ->withMeta([
                                        'value' => head($amenity->options),
                                        'default' => head($amenity->options),
                                    ]);
                            }
                        })
                    ]; 
                })
                ->fillUsing(function($pivots) {
                    return array_merge($pivots, [
                        'has_metadata_type' => static::newModel()->getMorphClass()
                    ]);
                })
                ->hideFromIndex(),

            Trix::make(__("Applicant Explanations"), 'explanation')
                ->nullable(),

            Trix::make(__("Agent Notes"), 'note')
                ->nullable(), 
            

            new Panel(__("Address"), [  
                Text::make(__("Full Address"), 'address')
                    ->hideFromIndex()
                    ->required()
                    ->rules('required'), 

                MapMarker::make(__("Map Location"))
                    ->defaultLatitude('29.696291745877')
                    ->defaultLongitude('52.464620624931')
                    ->defaultZoom(12)
                    ->centerCircle(500), 
            ]),  
        ];
    } 
}
