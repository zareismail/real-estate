<?php

namespace Zareismail\RealEstate;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 
use Zareismail\Amenity\Amenitieable;   

class RealEstateDeal extends Model 
{
    use SoftDeletes;   

    public static function periods()
    {
    	return [
    		'hour'  => __("Hour"),
    		'day'   => __("Day"),
    		'week'  => __("Week"),
    		'month' => __("Month"),
    		'year'  => __("Year"),
    	];
    }

    public static function pricings()
    {
    	return [
    		'adaptive' => __("Adaptive"), 
    		'certain'  => __("Certain"), 
    		'mortgage' => __("Mortgage"),
    	];
    }
}
