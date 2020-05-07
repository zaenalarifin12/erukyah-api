<?php

namespace App\Http\Controllers\Api\Lokasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CekLokasiController extends Controller
{
    public function provinsi()
    {
        $daerah = DB::table("provinsi")->get();
        return response()->json($daerah);
    }

    public function kabupaten()
    {
        $daerah = DB::table("kabupaten")->get();
        return response()->json($daerah);
    }

    public function kecamatan()
    {
        $daerah = DB::table("kecamatan")->get();
        return response()->json($daerah);
    }

    public function desa()
    {
        $daerah = DB::table("desa")->get();
        return response()->json($daerah);
    }
}
