<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KondisiDinding extends Model
{
    use SoftDeletes;
    
    protected $primaryKey = 'idKondisiDinding';

    protected $table = "kondisiDinding";

    protected $fillable = [
        "idKondisiDinding",
        "namaKondisiDinding", 
        "skorKondisiDinding"
    ];

    public function transaksi()
    {
        return $this->hasMany("App\Models\Transaksi", "idLantai", "idLantai");
    }
}
