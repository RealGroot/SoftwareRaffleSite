<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SoftwareKey extends Model
{
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'software_keys';

	/**
	 * The model's default values for attributes.
	 *
	 * @var array
	 */
	protected $attributes = [
		'raffled' => false,
	];

	/**
	 * Get the parent software key this key is associated with.
	 */
	public function parent_key()
	{
		return $this->belongsTo('App\SoftwareKey', 'parent_id');
	}

	/**
	 * Get the child software keys this key is associated with.
	 */
	public function child_keys()
	{
		return $this->hasMany(SoftwareKey::class);
	}

	/**
	 * Get the user this key belongs to.
	 */
	public function user()
	{
		return $this->belongsTo(User::class, 'owner_id');
	}
}
