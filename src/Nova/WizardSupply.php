<?php

namespace Zareismail\RealEstate\Nova;
  
use Laravel\Nova\Http\Requests\NovaRequest;
use Illuminate\Http\Request;  
use Laravel\Nova\Fields\ID;    
use Laravel\Nova\Fields\Text;   
use Laravel\Nova\Fields\Select; 
use Laravel\Nova\Fields\Heading; 
use Laravel\Nova\Fields\TextArea;   
use Laravel\Nova\Fields\BelongsTo;    
use Armincms\Fields\BelongsToMany;
use Armincms\Fields\MorphToMany;
use Zareismail\NovaLocation\Nova\Settlement;
use Zareismail\NovaContracts\Nova\User;
use GeneaLabs\NovaMapMarkerField\MapMarker; 
use Zareismail\NovaWizard\Step;
use Zareismail\NovaWizard\Contracts\Wizard;  
use OptimistDigital\MultiselectField\Multiselect;
use Zareismail\RealEstate\Helper; 


class WizardSupply extends Supply implements Wizard
{      
    use InteractsWithCustomer, InteractsWithPricings;

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return __('Supplies');
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

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [  
            (new Step(__('Request'), [      

                ID::make('ID')->sortable(),  

                $this->customerField(),

                BelongsTo::make(__('Applicant'), 'applicant', Customer::class)
                    ->exceptOnForms()
                    ->withoutTrashed(), 
 
                $this->dealableField(__('Request'))
                    ->display(function($resource) {
                        return $resource->supply ?? $resource->name;
                    })
                    ->pivots(false),

                BelongsTo::make(__('Property Type'), 'kind', Kind::class)
                    ->withoutTrashed()
                    ->required()
                    ->rules('required'),  

                BelongsTo::make(__('Uses of property'), 'uses', Uses::class)
                    ->withoutTrashed()
                    ->required()
                    ->rules('required'), 

                BelongsTo::make(__('Settlement'), 'settlement', Settlement::class)
                    ->withoutTrashed()
                    ->required()
                    ->rules('required'), 

                BelongsToMany::make('Agencies', 'agencies', Agency::class)
                    ->exceptOnForms(),

                Select::make(__('Responsible Agency'), 'agency')
                    ->options(Helper::userRelatedAgencies($request->user())->pluck('name', 'id'))
                    ->required()
                    ->rules('required')
                    ->displayUsingLabels()
                    ->fillUsing(function($request, $model, $attribute) {
                        $model::saved(function($model) use ($request) {
                            $model->agencies()->where('shared', 0)->sync($request->get('agency')); 
                        });
                    })
                    ->resolveUsing(function($value, $resource) {
                        return optional($resource->agencies->first(function($agency) {
                            return (int) optional($agency->pivot)->shared;
                        }))->id;
                    })
                    ->onlyOnForms(),  

            ]))->checkpoint()->withToolbar(),  
 
            // new Step(__('Applicant Information'),  $this->customerProfile()),   
            //  
            new Step(__('Pricing'), collect($this->deals)->map(function($deal) use ($request) {
                return $this->filter($this->dealPricingField($request, $deal->name, $deal->id, $deal->pricing));
            })->flatten()->all()),

            new Step(__('Location'), [  

                Select::make(__('Responsible'), 'agent_id') 
                    ->options(
                        User::newModel()->whereId($request->user()->id)->orWhereHas('agencies', function($q) {
                            $agency = $this->resource->agencies->where('shared', 1)->first();

                            return $q->where($q->qualifyColumn('id'), optional($agency)->id);
                        })->get()->keyBy('id')->map(function($user) {
                            return $user->mobile .($user->fullname() ? '-' : ''). $user->fullname();
                        })
                    )
                    ->required()
                    ->rules('required')
                    ->hideFromIndex()
                    ->displayUsingLabels(),

                Text::make(__('Property Address'), 'address') 
                    ->required()
                    ->rules('required')
                    ->hideFromIndex(),

                MapMarker::make(__('Map Location'))
                    ->defaultLatitude('29.696291745877')
                    ->defaultLongitude('52.464620624931')
                    ->defaultZoom(12)
                    ->centerCircle(500)
                    ->required() 
                    ->hideFromIndex(), 
            ]), 

            new Step(__('Property Amenities'), $this->resource->kind->metadatas()->get()->map(function($metadata) {
                $fieldClass = class_exists($metadata->field) ? $metadata->field : Text::class;
                $attribute = "metadatas[{$metadata->id}][value]";

                return tap($fieldClass::make($metadata->name, $attribute), function($field) use ($metadata) {

                    if(method_exists($field, 'options')){
                        $field->options($metadata->options);
                    }

                    $field
                        ->fillUsing(function($request, $model, $attribute) {
                            $model::saved(function($model) use ($request) {
                                $model->metadatas()->sync((array) $request->get('metadatas'));
                            });
                        })
                        ->resolveUsing(function($value, $resource) use ($metadata) {
                            if($metadata = $resource->metadatas->where('id', $metadata->id)->first()) {
                                return $metadata->pivot->value;
                            }
                        })
                        ->hideFromIndex(); 
                }); 
            })),  
        ];
    }   
}
