<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KondisiAtap extends Model
{
    use SoftDeletes;
    
    protected $primaryKey = 'idKondisiAtap';

    protected $table = "kondisiAtap";
    
    protected $fillable = [
        "idKondisiAtap",
        "namaKondisiAtap", 
        "skorKondisiAtap"
    ];

    protected $hidden = [
        'deleted_at', 'created_at', 'updated_at'
    ];

    public function transaksi()
    {
        return $this->hasMany("App\Models\Transaksi", "idLantai", "idLantai");
    }
}
