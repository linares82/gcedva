<?php

namespace App;

use Hash;
use Illuminate\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Esensi\Model\Traits\ValidatingModelTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Auth\Passwords\CanResetPassword;
use Esensi\Model\Contracts\ValidatingModelInterface;
use Acoustep\EntrustGui\Contracts\HashMethodInterface;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Venturecraft\Revisionable\RevisionableTrait;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract, ValidatingModelInterface, HashMethodInterface
{
    use Authenticatable, CanResetPassword, ValidatingModelTrait, EntrustUserTrait, Notifiable;
    use SoftDeletes { SoftDeletes::restore insteadof EntrustUserTrait; }
    use RevisionableTrait;

    protected $throwValidationExceptions = true;

    public static function boot()
	{
		parent::boot();

	    static::creating(function ($model) {
	            // Remember that $model here is an instance of Article
	            $model->usu_alta_id = Auth::user()->id;
				$model->usu_mod_id = Auth::user()->id;
        });

		static::updating(function ($model) {
			// Remember that $model here is an instance of Article
			$model->usu_mod_id = Auth::user()->id;
            
		});

		static::deleting(function ($model) {
			// Remember that $model here is an instance of Article
            //dd('borrando');
			$model->usu_delete_id = Auth::user()->id;
            $model->save();
		});

	}

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
