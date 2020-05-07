<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    
    protected $primaryKey   = "idKecamatan";
    protected $table        = "kecamatan";
    protected $fillable     = ["idKecamatan", "nama", "idKabupaten"];

    public function penduduk()
    {
        return $this->hasMany("App\Models\Penduduk");
    }
}
