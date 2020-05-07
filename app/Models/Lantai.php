<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lantai extends Model
{
    use SoftDeletes;
    
    protected $primaryKey = 'idLantai';

    protected $table = "lantai";

    protected $fillable = [
        "idLantai",
        "namaLantai",
        "skorLantai"
    ];

    public function transaksi()
    {
        return $this->hasMany("App\Models\Transaksi", "idLantai", "idLantai");
    }
}
