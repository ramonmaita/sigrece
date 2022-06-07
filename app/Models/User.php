<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements Auditable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use \OwenIt\Auditing\Auditable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // modifique los atributos en Actions
    protected $fillable = [
        'cedula',
        'nombre',
        'apellido',
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
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function adminlte_image()
    {
        // url de foto
        return $this->profile_photo_url;
        return 'https://picsum.photos/300/300';
    }

    public function adminlte_desc()
    {
        return $this->email;
    }

    public function adminlte_profile_url()
    {
        return 'profile/username';
    }

	public function Logins()
	{
		return $this->hasMany(Login::class)->orderBy('created_at','desc');
	}

	public function Coordinador()
	{
		return $this->hasOne(Coordinador::class);
	}

	public function Alumno()
	{
		return $this->hasOne(Alumno::class,'cedula','cedula');
	}
	public function Docente()
	{
		return $this->hasOne(Docente::class,'cedula','cedula');
	}
	public function getNombreCompletoAttribute()
	{
	    return $this->nombre . ' ' . $this->apellido;
	}
}
