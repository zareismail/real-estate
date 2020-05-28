<?php

namespace Zareismail\RealEstate;
 

class RealEstateSupply extends RealEstateRequest
{   
    public function kind()
    {
        return $this->belongsTo(RealEstateKind::class);
    }

    public function uses()
    {
        return $this->belongsTo(RealEstateUse::class, 'use_id');
    }
}
