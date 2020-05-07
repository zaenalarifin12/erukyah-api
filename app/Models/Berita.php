<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Berita extends Model
{
    use SoftDeletes;
    
    protected $primaryKey = 'idBerita';

    protected $table = "berita";

    protected $fillable = [
        "judulBerita", "slugBerita", "uraianBerita", "fileBerita", "idUser"
    ];

    public function user()
    {
        return $this->belongsTo("App\User");
    }

}
