<?php

namespace Zareismail\RealEstate; 


class RealEstateDemand extends RealEstateRequest
{ 
    public function kinds()
    {
        return $this->morphToMany(RealEstateKind::class, 'kindable', 'real_estate_kindables');
    }

    public function uses()
    {
        return $this->morphToMany(RealEstateUse::class, 'usable', 'real_estate_usables');
    }

    public function settlements()
    {
        return $this->locations();
    }
}
