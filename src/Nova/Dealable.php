<?php

namespace Zareismail\RealEstate\Nova;
  
use OwenMelbz\RadioField\RadioButton;
use Armincms\Fields\BelongsToMany; 
use Rimu\FormattedNumber\FormattedNumber;

trait Dealable 
{ 
	public function dealableField($name = 'Appropriate Deals')
	{
		return BelongsToMany::make(__($name), 'deals', Deal::class) 
                ->required()
                ->rules('required')
                ->fields(function($request, $resource) {
                    $deal = Deal::$model::findOrFail($request->relatedId);

                    return [ 
                        RadioButton::make(__("Adaptive Price"), 'adaptive')
                            ->options([
                                __("No"), __("Yes")
                            ])
                            ->default(0)
                            ->toggle([
                                1 => ['min_periodical', 'max_periodical', 'min_certain', 'max_certain']
                            ]),

                        $this->mergeWhen(! $request->adaptive && $deal->pricing === 'certain', [   
                            FormattedNumber::make(__("Min Price"), 'min_certain')
                                ->required()
                                ->rules('required')
                                ->format('0,00')
                                ->help(__("Toman")),

                            FormattedNumber::make(__("Max Price"), 'max_certain')
                                ->format('0,00')
                                ->help(__("Toman")),
                        ]),   

                        $this->mergeWhen(! $request->adaptive && $deal->pricing === 'mortgage', [  
                            FormattedNumber::make(__("Min Mortgage"), 'min_certain')
                                ->required()
                                ->rules('required')
                                ->format('0,00')
                                ->help(__("Toman")),

                            FormattedNumber::make(__("Min Rent"), 'min_periodical')
                                ->required()
                                ->rules('required')
                                ->format('0,00')
                                ->help(__("Toman")),

                            FormattedNumber::make(__("Max Mortgage"), 'max_certain')
                                ->format('0,00')
                                ->help(__("Toman")),

                            FormattedNumber::make(__("Max Rent"), 'max_periodical')
                                ->format('0,00')
                                ->help(__("Toman")),
                        ])
                    ];
                })
                ->fillUsing(function($pivots) { 
                    return array_merge(array_filter((array) $pivots), [
                        'dealable_type' => static::newModel()->getMorphClass()
                    ]);
                })
                ->pivots();
	}
}
