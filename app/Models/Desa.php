<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Desa extends Model
{
    protected $primaryKey   = "idDesa";
    protected $table        = "desa";
    protected $fillable     = ["idDesa", "nama", "idKecamatan"];

    public function penduduk()
    {
        return $this->hasMany("App\Models\Penduduk");
    }
}
