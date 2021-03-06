<?php

namespace Zareismail\RealEstate\Nova;
  
use Zareismail\NovaContracts\Nova\User as Resource;
use Laravel\Nova\Http\Requests\NovaRequest;
use Illuminate\Http\Request;  
use Laravel\Nova\Fields\Text;
use Armincms\Fields\BelongsToMany;
use Zareismail\NovaPolicy\PolicyRole;

class Customer extends Resource
{ 

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'Zareismail\\RealEstate\\Customer'; 

    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'RealEstate';  

    /**
     * The relationships that should be eager loaded when performing an index query.
     *
     * @var array
     */
    public static $with = ['suppliers']; 

    /**
     * Get the value that should be displayed to represent the resource.
     *
     * @return string
     */
    public function title()
    {
        return $this->mobile .($this->resource->fullname() ? '-' : ''). $this->fullname();
    }

    /**
     * Determine if this resource is available for navigation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    public static function availableForNavigation(Request $request)
    { 
        return $request->user()->load(['roles' => function($q) {
            $q->where($q->qualifyColumn('id'), RealEstate::option('_rs_manager_'));
        }])->roles->isNotEmpty();
    }

    /**
     * Build an "index" query for the given resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->whereHas('suppliers', function($q) use ($request) {
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
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {    
        return [
            Text::make(__("Mobile Number"), 'mobile')
                ->required()
                ->creationRules([
                    'required',
                    function($attribute, $value, $fail) use ($request) { 
                        if($request->user()->customers()->where($attribute, $value)->first()) {
                            $fail('This user has been registered');
                        } 
                    }
                ])
                ->fillUsing(function($request, $model, $attribute) {
                    $model->forceFill([
                        'mobile'    => $request->mobile,
                        'name'      => $request->mobile,
                        'email'     => $request->mobile,
                        'password'  => $request->mobile,
                    ]);
                }),   
        ];
    } 

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fieldsForIndex(Request $request)
    {    
        return parent::fields($request);
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fieldsForDetail(Request $request)
    {    
        return static::fieldsForIndex($request);
    }

    /**
     * Fill a new model instance using the given request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return array
     */
    public static function fill(NovaRequest $request, $model)
    {   
        $model = tap(static::creationModel($request, $model), function($model) use ($request) {
            $model::saved(function($model) use ($request) {
                $model->suppliers()->attach($request->user()); 

                if($role = option('_rs_customer_')) {
                    $model->roles()->get()->where('id', $role)->count() || $model->roles()->attach($role);
                }
            });

            
        });

        return parent::fill($request, $model); 
    } 

    /**
     * Get a fresh instance of the model represented by the resource.
     *
     * @return mixed
     */
    public static function creationModel(NovaRequest $request, $model)
    {
        return $request->newQueryWithoutScopes()->whereMobile($request->mobile)->first() ?? $model;
    }

    /**
     * Get the actions available on the entity.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [
            (new Actions\RemoveCustomer)->showOnTableRow(),
        ];
    }

    /**
     * Determine if the current user can delete the given resource or throw an exception.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function authorizeToDelete(Request $request)
    {
        return false;
    }

    /**
     * Determine if the current user can delete the given resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    public function authorizedToDelete(Request $request)
    {
        return method_exists($request, 'action') && 
               get_class($request->action()) === Actions\RemoveCustomer::class;
    }


    /**
     * Determine if the current user can restore the given resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    public function authorizedToRestore(Request $request)
    {
        return false;
    }

    /**
     * Determine if the current user can force delete the given resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    public function authorizedToForceDelete(Request $request)
    {
        return false;
    }
}
