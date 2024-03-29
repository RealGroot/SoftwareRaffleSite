<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Watson\Rememberable\Rememberable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use Notifiable, EntrustUserTrait, Rememberable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

	public $rememberCacheTag = 'user_queries';

	public $rememberFor = 60 * 60 * 24;

	/**
	 * Get the software keys this user has.
	 */
	public function software_keys()
	{
		return $this->hasMany(SoftwareKey::class);
	}

	public function votes()
	{
		return $this->hasMany(RaffleVote::class, 'user_id', 'id');
	}
}
