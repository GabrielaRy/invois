<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
		'is_admin' => 'boolean'
    ];

	/**
	 * One user has many invoices
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function invoices()
	{
		return $this->hasMany(Invoice::class);
    }

	/**
	 * One user has many customers
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function customers()
	{
		return $this->hasMany(Customer::class);
    }
}
