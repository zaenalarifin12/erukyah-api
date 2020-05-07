<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Desa;

class LokasiController extends Controller
{
    public function provinsi()
    {
        $provinsi = Provinsi::get();
        return response()->json([
            "data" => $provinsi
        ]);
    }

    public function kabupaten($idProvinsi)
    {
        $kabupaten = Kabupaten::where("idProvinsi", $idProvinsi)->get();

        if($kabupaten == null) return response()->json([ "msg" => "data tidak ditemukan" ], 404);

        return response()->json([
            "data" => $kabupaten
        ]);
    }

    public function kecamatan($idKabupaten)
    {
        $kecamatan = Kecamatan::where("idKabupaten", $idKabupaten)->get();

        if($kecamatan == null) return response()->json([ "msg" => "data tidak ditemukan" ], 404);

        return response()->json([
            "data" => $kecamatan
        ]);
    }
    public function desa($idkecamatan)
    {
        $desa = Desa::where("idKecamatan", $idkecamatan)->get();

        if($desa == null) return response()->json([ "msg" => "data tidak ditemukan" ], 404);

        return response()->json([
            "data" => $desa
        ]);
    }

}
