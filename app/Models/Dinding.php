<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dinding extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'idDinding';

    protected $table = "dinding";
    
    protected $fillable = [
        "idDinding",
        "namaDinding", 
        "skorDinding"
    ];

    public function transaksi()
    {
        return $this->hasMany("App\Models\Transaksi", "idLantai", "idLantai");
    }
}
