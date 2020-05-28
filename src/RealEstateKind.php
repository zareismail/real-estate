<?php

namespace Zareismail\RealEstate;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 
use Zareismail\MetaData\HasMetadata;

class RealEstateKind extends Model 
{
    use SoftDeletes, HasMetadata;  
}
