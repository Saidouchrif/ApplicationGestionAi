<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livre extends Model
{
    use HasFactory;
    protected $table = 'livres';
    protected $primaryKey = 'id_livre';    
    protected $fillable = [
        'titre',
        'description',
        'image_url',
        'stock',
        'rating',
        'price',
    ];
    public function emprunts()
    {
        return $this->hasMany(Emprunt::class, 'id_livre');
    }
    public function historiqueEmprunts()
    {
        return $this->hasMany(HistoriqueEmprunt::class, 'id_livre');
    }
}
