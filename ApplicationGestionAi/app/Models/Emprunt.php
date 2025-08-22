<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emprunt extends Model
{
    use HasFactory;
    protected $table = 'emprunts';
    protected $primaryKey = 'id_emprunt';
    protected $fillable = [
        'id_adherent',
        'id_livre',
        'date_emprunt',
        'date_retour_prevue',
        'date_retour_effectif',
    ];
    public function adherent()
    {
        return $this->belongsTo(Adherent::class, 'id_adherent');
    }
    public function livre()
    {
        return $this->belongsTo(Livre::class, 'id_livre');
    }
}
