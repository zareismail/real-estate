<?php

namespace Zareismail\RealEstate\Nova;
 
use Zareismail\RealEstate\RealEstateDeal;
use Rimu\FormattedNumber\FormattedNumber;
use OwenMelbz\RadioField\RadioButton;
use Armincms\Fields\BelongsToMany; 
use Laravel\Nova\Fields\Heading; 

trait InteractsWithPricings
{ 
	public function dealPricingField($request, $name, $deal, $pricing)
	{   
		return [
			Heading::make($name),

			RadioButton::make(__('Adaptive Price'), $this->pricingAttribute('adaptive', $deal))
                ->options([__('No'), __('Yes')])
                ->default(0)
                ->toggle([
                    1 => [
                    	$this->pricingAttribute('min_periodical', $deal), 
                    	$this->pricingAttribute('max_periodical', $deal), 
                    	$this->pricingAttribute('min_certain', $deal), 
                    	$this->pricingAttribute('max_certain', $deal)
                    ]
                ])
                ->hideFromIndex()
                ->fillUsing(function($request, $model, $attribute) use ($deal) {
                    $adaptive = (int) $this->requestValue($request, $deal, 'adaptive') > 0;

                    $this->fillPricingFromRequest($request, $model, 'adaptive', $deal, $adaptive);
                })
                ->resolveUsing(function($value, $resource) use ($deal) {
                    return $resource->deals->first(function($model) use ($deal) {
                        return $model->id == $deal;
                    })->pivot->adaptive;
                }),

            $this->mergeWhen((int) $this->requestValue($request, $deal, 'adaptive') < 1 && $pricing === 'certain', [
                $this->priceField(__('Min Price'), 'min_certain', $deal, false),
                $this->priceField(__('Max Price'), 'max_certain', $deal), 
            ]),   

            $this->mergeWhen((int) $this->requestValue($request, $deal, 'adaptive') < 1 && $pricing === 'mortgage', [  
                $this->priceField(__('Min Mortgage'), 'min_certain', $deal, false),  
                $this->priceField(__('Min Rent'), 'min_periodical', $deal, false),   
                $this->priceField(__('Max Mortgage'), 'max_certain', $deal, false),   
                $this->priceField(__('Max Rent'), 'max_periodical', $deal),     
            ])
		];
	}   

    public function priceField($name, $attribute, $deal, $update = true)
    {
        return FormattedNumber::make($name, $this->pricingAttribute($attribute, $deal))
                    ->format('0,00')
                    ->help(__('Toman'))
                    ->hideFromIndex()
                    ->fillUsing(function($request, $model) use ($deal, $update, $attribute) {
                        $this->fillPricingFromRequest($request, $model, $attribute, $deal, $update); 
                    })
                    ->resolveUsing(function($value, $resource) use ($deal, $attribute) {
                        if($pivot = $this->dealPivot($deal)) {
                            return $pivot->{$attribute};
                        } 
                    });
    }

    public function fillPricingFromRequest($request, $model, $attribute, $deal, $update = false)
    {
        if($pivot = $this->dealPivot($deal)) {
            $pivot->{$attribute} = floatval($this->requestValue($request, $deal, $attribute)); 
            $update && $pivot->save();  
        }
    } 

    public function dealPivot($deal)
    {
        return  optional($this->resource->deals->first(function($model) use ($deal) {
                    return $model->id == $deal;
                }))->pivot;
    }

	public function pricingAttribute($attribute, $id)
	{
		return "pricings[{$id}][{$attribute}]";
	}

    public function requestValue($request, $id, $attribute)
    { 
        return $request->input("pricings.{$id}.{$attribute}");
    }
}