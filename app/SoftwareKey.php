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

	protected $fillable = [
		'title',
		'key',
		'platform_id',
		'shop_link',
		'back_img_link',
		'instruction_link',
		'parent_id',
	];

	/**
	 * Get the parent software key this key is associated with.
	 */
	public function parent_key()
	{
		return $this->belongsTo(SoftwareKey::class, 'parent_id');
	}

	/**
	 * Get the child software keys this key is associated with.
	 */
	public function child_keys()
	{
		return $this->hasMany(SoftwareKey::class, 'parent_id');
	}

	/**
	 * Get the user this key belongs to.
	 */
	public function user()
	{
		return $this->belongsTo(User::class, 'owner_id');
	}

	/**
	 * Gets the platform this software key exists for.
	 */
	public function platform()
	{
		return $this->hasOne(Platform::class, 'id', 'platform_id');
	}

	public function user_votes()
	{
		return $this->hasMany(RaffleVote::class, 'software_id', 'id');
	}
}
