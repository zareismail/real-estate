<?php

namespace Zareismail\RealEstate;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;    
use Zareismail\Contracts\Auth\Authorizable;
use Zareismail\Contracts\Auth\Authorization;
use Zareismail\MetaData\HasMetadata;
use Zareismail\NovaLocation\Locatable;
use Zareismail\NovaPolicy\Contracts\Ownable;

class RealEstateRequest extends Model implements Authorizable, Ownable
{
    use SoftDeletes, Authorization, HasMetadata, Dealable, Locatable; 

    protected $with = [
        'deals'
    ];

    /**
     * Indicate Model Authenticatable.
     * 
     * @return mixed
     */
    public function owner()
    {
        return $this->auth();
    }

    public function applicant()
    {
        return $this->authenticatable('applicant_id');
    }

    public function agent()
    {
        return $this->authenticatable('agent_id');
    } 

    public function agencies()
    {
        return $this->morphToMany(RealEstateAgency::class, 'request', 'real_estate_request_agency')
                        ->withPivot('shared', 'id');
    }

    public function responsibles()
    {
        return $this->agencies()->wherePivot('shared', 0);
    }

    public function shares()
    {
        return $this->agencies()->wherePivot('shared', 1);
    } 
}
