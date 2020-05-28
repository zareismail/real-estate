<?php 

namespace Zareismail\RealEstate;

trait Dealable
{

    public function deals()
    {
        return $this->morphToMany(RealEstateDeal::class, 'dealable', 'real_estate_dealables')
        			->withPivot('id', 'adaptive', 'min_certain', 'max_certain', 'min_periodical', 'max_periodical');
    }
}