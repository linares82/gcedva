<?php

namespace App;

use Hash;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Esensi\Model\Traits\ValidatingModelTrait;
use Illuminate\Auth\Passwords\CanResetPassword;
use Esensi\Model\Contracts\ValidatingModelInterface;
use Acoustep\EntrustGui\Contracts\HashMethodInterface;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract, ValidatingModelInterface, HashMethodInterface
{
    use Authenticatable, CanResetPassword, ValidatingModelTrait, EntrustUserTrait, Notifiable;

    protected $throwValidationExceptions = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'api_token','id_telegram'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    protected $hashable = ['password'];

    protected $rulesets = [

        'creating' => [
            'email'      => 'required|email|unique:users',
            'password'   => 'required',
        ],

        'updating' => [
            'email'      => 'required|email|unique:users',
            'password'   => '',
        ],
    ];

    public function entrustPasswordHash()
    {
        $this->password = Hash::make($this->password);
        $this->save();
    }

    public function empleado()
    {
        return $this->belongsTo('App\Empleado', 'empleado_id', 'id');
    }

    public function routeNotificationForTelegram()
    {
        //dd($this->id_telegram);
        return $this->id_telegram;
        //return 798978336; //FLC
    }

    public function roles1(){
        return $this->belongsToMany('App\Role','role_user','user_id','role_id');
    }
}
