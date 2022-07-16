<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
 
use Tymon\JWTAuth\Contracts\JWTSubject;
 
class User extends Authenticatable implements JWTSubject {
    use HasFactory, Notifiable;
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'active',
        'perfil_id',
        'cpf'
    ];

    protected $hidden = [
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function perfil() {
        return $this->hasOne(Perfil::class, 'id', 'perfil_id');
    }

    public function getJWTIdentifier() {
        return $this->getKey();
    }

    public function getJWTCustomClaims() {
        return [
            'user' => [
                'id' => $this->id,
                'name' => $this->name,
                'email' => $this->email,
            ]
        ];
    }

    public function hasPermission($pemrissionSlug, $type) {
        $permission = Permissao::where('sigla', $pemrissionSlug)->first();
        $rolePermission = PerfilPermissao::where('perfil', $this->perfil_id)
            ->where('permissao', $permission->id)
            ->first();

        return $rolePermission->$type === 'S';
    }
}