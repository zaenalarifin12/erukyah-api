<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaksi extends Model
{
    use SoftDeletes;
    
    protected $primaryKey = "idTransaksi";
    
    protected $table = "transaksi";

    protected $fillable = [
        "nokk",
        "nik",
        "latitude",
        "longtitude",
        "fotoDepan",
        "fotoLantai",
        "fotoDinding",
        "fotoAtap",
        "idLantai",
        "idDinding",
        "idKondisiDinding",
        "idAtap",
        "idKondisiAtap",
        "idUser",
    ];

    public function lantai()
    {
        return $this->belongsTo("App\Models\Lantai", "idLantai", "idLantai");
    }

    public function dinding()
    {
        return $this->belongsTo("App\Models\Dinding", "idDinding", "idDinding");
    }

    public function kondisiDinding()
    {
        return $this->belongsTo("App\Models\KondisiDinding", "idKondisiDinding", "idKondisiDinding");
    }

    public function atap()
    {
        return $this->belongsTo("App\Models\Atap", "idAtap", "idAtap");
    }

    public function kondisiAtap()
    {
        return $this->belongsTo("App\Models\KondisiAtap", "idKondisiAtap", "idKondisiAtap");
    }

    public function user()
    {
        return $this->belongsTo("App\User", "idUser", "idUser");
    }
}
