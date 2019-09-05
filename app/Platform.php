<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
	/**
	 * Get software keys that exist for this platform.
	 */
	public function software_keys()
	{
		return $this->belongsTo(SoftwareKey::class, 'platform_id');
	}
}
