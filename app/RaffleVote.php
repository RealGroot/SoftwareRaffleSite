<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class RaffleVote extends Model
{
	public function __construct(array $attributes = [])
	{
		$attributes['id'] = $attributes['id'] ?? Str::uuid();
		parent::__construct($attributes);
	}

	public $incrementing = false;

	protected $keyType = 'string';

	protected $fillable = ['id', 'user_id', 'software_id'];

	public function user()
	{
		return $this->hasOne(User::class, 'id', 'user_id');
	}

	public function software()
	{
		return $this->hasOne(SoftwareKey::class, 'id', 'software_id');
	}
}
