<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'password', 'cnp'
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
     * @return string
     */
    public function generatePassword()
    {
        $unhashedPassword = str_random(14);
        $this->password = Hash::make($unhashedPassword);
        $this->save();

        return $unhashedPassword;
    }

    /**
     * @return string
     */
    public function generateToken()
    {
        $this->api_token = str_random(60);
        $this->save();

        return $this->api_token;
    }

    /**
     * @return string
     */
    public function generateCnp()
    {
        $this->cnp = str_random(60);
        $this->save();

        return $this->cnp;
    }
}