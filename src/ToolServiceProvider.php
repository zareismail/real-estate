<?php

namespace Zareismail\RealEstate;
 
use Illuminate\Foundation\Support\Providers\AuthServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova as LaravelNova;
use Zareismail\RealEstate\Http\Middleware\Authorize;
use Illuminate\Database\Eloquent\Builder; 
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Gate; 


class ToolServiceProvider extends AuthServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [ 
        Customer::class         => Policies\Customer::class,
        Employee::class         => Policies\Employee::class,
        Option::class           => Policies\RealEstate::class,
        Metadata::class         => Policies\RealEstateMetadata::class,
        RealEstateAgency::class => Policies\RealEstateAgency::class,
        RealEstateSupply::class => Policies\RealEstateSupply::class,
        RealEstateDemand::class => Policies\RealEstateDemand::class,
    ];

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {  
        $this->app['config']->set('nova.name', 'Real Estate'); 
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->registerPolicies(); 
        $this->registerRelationships(); 
        LaravelNova::serving([$this, 'servingNova']);
    } 

    public function servingNova()
    {
        LaravelNova::resources([
            Nova\Deal::class, 
            Nova\Uses::class, 
            Nova\Kind::class,
            Nova\Agency::class,  
            Nova\Supply::class, 
            Nova\Demand::class, 
            Nova\Manager::class, 
            Nova\Amenity::class,
            Nova\Employee::class, 
            Nova\Customer::class, 
            Nova\RealEstate::class,
            Nova\WizardSupply::class, 
            Nova\RealEstateConfiguration::class,
        ]);
    }

    public function registerRelationships()
    {
        Builder::macro('agencies', function() {
            $model = $this->getModel();
            
            if($model instanceof Authenticatable) {
                 return $model->belongsToMany(
                    RealEstateAgency::class, 'real_estate_agency_user' 
                );
            }

            unset(static::$macros['agencies']);

            return $model->agencies();
        });

        Builder::macro('employees', function() {
            $model = $this->getModel();
            
            if($model instanceof Authenticatable) {
                return $model->belongsToMany(
                    $model, 'real_estate_employees', 'employee_id', 'employer_id'
                );
            }

            unset(static::$macros['employees']);

            return $model->employees();
        });

        Builder::macro('employers', function() {
            $model = $this->getModel();
            
            if($model instanceof Authenticatable) {
                return $model->belongsToMany(
                    $model, 'real_estate_employees', 'employer_id', 'employee_id'
                );
            }

            unset(static::$macros['employers']);

            return $model->employers();
        });

        Builder::macro('customers', function() {
            $model = $this->getModel();
            
            if($model instanceof Authenticatable) {
                return $model->belongsToMany(
                    $model, 'real_estate_customers', 'customer_id', 'supplier_id'
                );
            }

            unset(static::$macros['customers']);

            return $model->customers();
        });

        Builder::macro('suppliers', function() {
            $model = $this->getModel();
            
            if($model instanceof Authenticatable) {
                return $model->belongsToMany(
                    $model, 'real_estate_customers', 'supplier_id', 'customer_id'
                );
            }

            unset(static::$macros['suppliers']);

            return $model->suppliers();
        }); 
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        
    }
}
