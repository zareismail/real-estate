<?php

namespace Zareismail\RealEstate\Nova;

use Zareismail\NovaContracts\Nova\User;
use Zareismail\RealEstate\Helper;
use Laravel\Nova\Fields\Text;   
use Armincms\Json\Json;

trait InteractsWithCustomer
{ 
	public function customerField()
	{ 
		return Text::make(__("Applicant Mobiles"), "mobile")
                    ->required()
                    ->rules('required', 'max:15')
                    ->fillUsing(function($request, $model, $attribute, $requestAttribute) {  
                    	$agency = Agency::newModel()->find((int) $request->get('agency'));
                        $applicant = $this->firstOrCreateCustomer($request->get($requestAttribute));  
                        // after applicant create, we need attach to agency customers
                        Helper::addAgencyCustomer($agency, $applicant);  

                        $model->saving(function($supply) use ($applicant, $request) {
                            $supply->applicant()->associate($applicant); 
                            $supply->agent()->associate($request->user()); 
                        }); 
                    })
                    ->resolveUsing(function() {   
                        return optional($this->resource->applicant)->mobile;
                    })
                    ->onlyOnForms();
	}

	public function customerProfile()
	{
		return Json::make('profile', [
			Text::make(__('Applicate firstname'), 'firstname')
                ->required()
                ->rules('required')
                ->fillUsing(function($request, $model, $attribute, $requestAttribute) {  
                    $model->applicant->forceFill([
                        'firstname' => $request->get($requestAttribute)
                    ]); 
                }),

            Text::make(__('Applicate lastname'), 'lastname')
                ->required()
                ->rules('required')
                ->fillUsing(function($request, $model, $attribute, $requestAttribute) { 
                    $model->applicant->forceFill([
                        'lastname' => $request->get($requestAttribute)
                    ])->save();  
                }),  
		])->saveHistory()->toArray();
	}

    public function firstOrCreateCustomer(string $mobile)
    {   
    	$model = User::newModel();

    	if(is_null($user = $model->whereMobile($mobile)->first())) { 
    		$model::unguard(); 

            $user = $model->create([
                'name'  => $mobile,
                'mobile'=> $mobile, 
                'password' => bcrypt($mobile),
            ]);
    	}   

    	return $user;
    }  
}