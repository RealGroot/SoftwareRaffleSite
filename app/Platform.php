<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Watson\Rememberable\Rememberable;

class Platform extends Model
{
	use Rememberable;

	public $rememberCacheTag = 'platform_queries';

	public $rememberFor = 60 * 60 * 24 * 7;

	/**
	 * Get software keys that exist for this platform.
	 */
	public function software_keys()
	{
		return $this->belongsTo(SoftwareKey::class, 'platform_id');
	}
}
