<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    protected $primaryKey   = "idProvinsi";
    protected $table        = "provinsi";
    protected $fillable     = ["idProvinsi", "nama"];

    public function penduduk()
    {
        return $this->hasMany("App\Models\Penduduk");
    }
}
