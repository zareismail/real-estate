<?php

namespace Zareismail\RealEstate\Nova;
  
use Laravel\Nova\Http\Requests\NovaRequest;
use Illuminate\Http\Request; 
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;      
use Laravel\Nova\Fields\BelongsTo;  
use Armincms\Fields\BelongsToMany;
use GeneaLabs\NovaMapMarkerField\MapMarker;
use Zareismail\NovaLocation\Nova\Settlement;  
use Zareismail\NovaContracts\Nova\User;
use Zareismail\NovaPolicy\Helper;

class Agency extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'Zareismail\\RealEstate\\RealEstateAgency'; 

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'name', 'guild_id'
    ]; 

    /**
     * The relationships that should be eager loaded when performing an index query.
     *
     * @var array
     */
    public static $with = [
        'location'
    ];

    /**
     * Build an "index" query for the given resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->when($request->user()->cant(Helper::WILD_CARD_PERMISSION), function($query) { 
            return static::newModel()->scopeAuthenticate($query);
        });
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
            ID::make()->sortable(), 

            BelongsTo::make(__('Owner'), 'auth', User::class)
                ->withoutTrashed()
                ->nullable()
                ->default($request->user())
                ->hideFromIndex()
                ->canSee(function($request) {
                    return $request->user()->can('addUser');
                }),

            BelongsTo::make(__('Manager'), 'manager', Manager::class)
                ->withoutTrashed()
                ->nullable()
                ->default($request->user())
                ->hideFromIndex() 
                ->canSee(function($request) {
                    return $request->user()->can('addManager', $this->resource);
                }),

            BelongsTo::make(__('Location'), 'settlement', Settlement::class)
                ->withoutTrashed()
                ->nullable()
                ->required()
                ->rules('required')
                ->sortable(),   

            // BelongsToMany::make(__('Employees'), 'employees', Employee::class) 
            //     ->hideFromIndex(),

            Text::make(__('Guild ID'), 'guild_id')
                ->required()
                ->rules('required')
                ->creationRules('unique:real_estate_agencies,guild_id')
                ->updateRules('unique:real_estate_agencies,guild_id,{{resourceId}}')
                ->hideFromIndex(),

            Text::make(__('Agency Name'), 'name')
                ->required()
                ->rules('required'),

            Text::make(__('Slogan'), 'slogan')
                ->nullable(),

            Text::make(__('Address'), 'address')
                ->required()
                ->rules('required')
                ->hideFromIndex(),

            Text::make(__('Zipcode'), 'zipcode')
                ->nullable()
                ->hideFromIndex(), 

            MapMarker::make(__("Map Location"))
                ->defaultLatitude('29.696291745877')
                ->defaultLongitude('52.464620624931')
                ->defaultZoom(12)
                ->centerCircle(500)
                ->hideFromIndex(),  
        ];
    } 
}
