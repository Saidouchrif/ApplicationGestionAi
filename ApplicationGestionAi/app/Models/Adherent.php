<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adherent extends Model implements AuthenticatableContract
{
    use HasFactory,Authenticatable;
    protected $table = 'adherents';
    protected $primaryKey = 'id_adherent';
    protected $fillable = [
        'nom',
        'email',
        'password_hash',
        'role',
        'date_inscription',
    ];
    protected $hidden = [
        'password_hash',
        'remember_token',
    ];
    protected $casts = [
        'date_inscription' => 'datetime',
    ];
    public function getAuthPassword()
    {
        return $this->password_hash;
    }
    public function emprunts()
    {
        return $this->hasMany(Emprunt::class, 'id_adherent');
    }
    public function getAuthIdentifier()
    {
        return $this->id_adherent;
    }
    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'id_adherent');
    }
}
