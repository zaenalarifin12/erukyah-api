<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kabupaten extends Model
{
    protected $primaryKey   = "idKabupaten";
    protected $table        = "kabupaten";
    protected $fillable     = ["idKabupaten", "nama", "idProvinsi"];

    public function penduduk()
    {
        return $this->hasMany("App\Models\Penduduk");
    }
}
