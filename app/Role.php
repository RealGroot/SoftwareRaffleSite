<?php

namespace App;

use Watson\Rememberable\Rememberable;
use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
	use Rememberable;

	public $rememberCacheTag = 'role_queries';

	public $rememberFor = 60 * 60 * 24;
}
