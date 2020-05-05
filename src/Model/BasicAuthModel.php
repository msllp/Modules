<?php
/**
 * Created by PhpStorm.
 * User: ms
 * Date: 14-03-2019
 * Time: 04:55 AM
 */
use \Illuminate\Contracts\Auth\Authenticatable;
use \Illuminate\Notifications\Notifiable;

class BasicAuthModel implements Authenticatable{

    use Notifiable;

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
}