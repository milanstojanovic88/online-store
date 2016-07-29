<?php

namespace App;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class User extends Model implements Authenticatable
{
    use \Illuminate\Auth\Authenticatable;

	/**
	 * @var array
	 */
	protected $fillable = [
		'email',
		'password',
		'confirmation_code',
		'name'
	];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function orders()
	{
	    return $this->hasMany(Order::class);
	}
}
