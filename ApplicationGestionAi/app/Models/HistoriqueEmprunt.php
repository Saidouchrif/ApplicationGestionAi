<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoriqueEmprunt extends Model
{
    use HasFactory;
    protected $table = 'historique_emprunts';
    protected $primaryKey = 'id_historique_emprunt';
    protected $fillable = [
        'id_adherent',
        'id_livre',
        'note',
        'date_emprunt',
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
