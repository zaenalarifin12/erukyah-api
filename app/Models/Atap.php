<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Atap extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'idAtap';

    protected $table = "atap";
    
    protected $fillable = [
        "idAtap",
        "namaAtap", 
        "skorAtap"
    ];

    public function transaksi()
    {
        return $this->hasMany("App\Models\Transaksi", "idLantai", "idLantai");
    }
}
