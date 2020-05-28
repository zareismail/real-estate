<?php

namespace Zareismail\RealEstate;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Zareismail\NovaContracts\IntractsWithMedia; 
use Zareismail\Contracts\Auth\Authorization; 
use Zareismail\Contracts\Auth\Authorizable;
use Zareismail\NovaLocation\Locatable;
use Zareismail\NovaPolicy\Contracts\Ownable; 

class RealEstateAgency extends Model implements /*HasMedia ,*/ Authorizable, Ownable
{
    use SoftDeletes, /*IntractsWithMedia,*/ Locatable, Authorization;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
    	'profile' => 'json'
    ];

	protected $medias = [
		'gallery' => [
			'multiple' => true,
			'disk' => 'armin.image',
			'schemas' => [
				'cover', '*',
			],
		],
		'avatar' => [
			'disk' => 'armin.image',
			'schemas' => [
				'avatar', 'thumbnail',
			],
		],
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

    public function manager()
    {
     	return $this->authenticatable('manager_id');
    }  

	public function employees()
	{
		return $this->belongsToMany(
			config('zareismail.user', \Zareismail\Contracts\User::class), 'real_estate_agency_user'
		);
	}
}
