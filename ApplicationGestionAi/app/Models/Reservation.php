<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
    protected $table = 'reservations';
    protected $primaryKey = 'id_reservation';
    protected $fillable = [
        'id_adherent',
        'id_livre',
        'date_reservation',
        'status',
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
