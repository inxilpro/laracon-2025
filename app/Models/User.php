<?php

namespace App\Models;

use App\Models\Types\UserTypes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements UserTypes
{
	use HasFactory;
	use Notifiable;
	
	protected $hidden = [
		'password',
		'remember_token',
	];
	
	protected function casts(): array
	{
		return [
			'email_verified_at' => 'datetime',
			'password' => 'hashed',
		];
	}
}
