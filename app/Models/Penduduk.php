<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penduduk extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'idPenduduk';

    protected $table = "penduduk";

    protected $fillable = [
        "nokk",
        "nik",
        "nama",
        "alamat",
        "latitude",
        "longtitude",
        "totalSkor",
        "tglPerbaikan",
        "noKontrak",
        "fotoRumahPerbaikan",
        "fotoLantai",
        "fotoDinding",
        "fotoAtap",
        "status",
        "idDesa",
        "idKecamatan",
        "idKabupaten",
        "idProvinsi",
        "idUser",
    ];

    public function desa()
    {
        return $this->belongsTo("App\Models\Desa", "idDesa", "idDesa");
    }

    public function kecamatan()
    {
        return $this->belongsTo("App\Models\Kecamatan", "idKecamatan", "idKecamatan");
    }

    public function kabupaten()
    {
        return $this->belongsTo("App\Models\Kabupaten", "idKabupaten", "idKabupaten");
    }

    public function provinsi()
    {
        return $this->belongsTo("App\Models\Provinsi", "idProvinsi", "idProvinsi");
    }

    public function user()
    {
        return $this->belongsTo("App\User", "idUser", "idUser");
    }

}
