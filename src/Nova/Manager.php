<?php

namespace Zareismail\RealEstate\Nova;
  
use Zareismail\NovaContracts\Nova\User as Resource;
use Laravel\Nova\Http\Requests\NovaRequest;
use Illuminate\Http\Request;   

class Manager extends Resource
{   
    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'RealEstate';   

    /**
     * Build an "index" query for the given resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->whereId($request->user()->id)->orWhereHas('employers', function($q) use ($request) {
            return $q->where($q->qualifyColumn('id'), $request->user()->id);
        });
    }

    /**
     * Build a "relatable" query for the given resource.
     *
     * This query determines which instances of the model may be attached to other resources.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function relatableQuery(NovaRequest $request, $query)
    {
        return parent::relatableQuery($request, $query);
    } 

    /**
     * Determine if this resource is available for navigation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    public static function availableForNavigation(Request $request)
    {
        return false;
    }
}
