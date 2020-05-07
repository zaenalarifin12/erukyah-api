<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Penduduk;
use App\Models\Lantai;
use App\Models\Dinding;
use App\Models\KondisiDinding;
use App\Models\Atap;
use App\Models\KondisiAtap;
use Validator;
use App\User;
use Auth;

class TransaksiController extends Controller
{
    /**
     * TODO
     * GET TRANSAKSI PER ID
     * POST TRANSAKSI
     *  JIKA PENDUDUK GAK ADA NULL
     * 
     * EDT TRANSAKSI 
     *  JIKA PENDUDUK STATUS RENOVASI 2 MAKA TIDAK BOLEH DIEDIT
     * 
     * DELETE
     *  JIKA PENDUDUK STATUS RENOVASI 2 MAKA TIDAK BOLEH DIHAPUS
     * 
     */
    public function index()
    {
        $transaksi = Transaksi::with([
            "lantai", 
            "dinding", 
            "kondisiDinding", 
            "atap", 
            "kondisiAtap",
            "user"
        ])->get();

        return response()->json([
            "msg"   => "berhasil menampilkan data transaksi",
            "data"  => $transaksi
        ]);
    }   

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "nokk"              => "required",
            "nik"               => "required",
            "latitude"          => "required",
            "longtitude"        => "required",
            "fotoDepan"         => "required",
            "fotoLantai"        => "required",
            "fotoDinding"       => "required",
            "fotoAtap"          => "required",
            "idLantai"          => "required",
            "idDinding"         => "required",
            "idKondisiDinding"  => "required",
            "idAtap"            => "required",
            "idKondisiAtap"     => "required",
        ]);

        if ($validator->fails())
            return response()->json(['msg'=>$validator->errors()], 401);            

        // validasi keadaan lokasi
        $cekPenduduk        = Penduduk::where("nokk",                   $request->nokk)->first();
        $cekLantai          = Lantai::where("idLantai",                 $request->idLantai)->first();
        $cekDinding         = Dinding::where("idDinding",               $request->idDinding)->first();
        $cekKondisiDinding  = KondisiDinding::where("idKondisiDinding", $request->idKondisiDinding)->first();
        $cekAtap            = Atap::where("idAtap",                     $request->idAtap)->first();
        $cekKondisiAtap     = KondisiAtap::where("idKondisiAtap",       $request->idKondisiAtap)->first();
        $cekTransaksi       = Transaksi::where([
            ["idUser",                 Auth::user()->idUser],
            ["nokk",                 $request->nokk],
        ]
            )->first();

        if(empty($cekPenduduk))
            return response()->json(['msg'=>"nokk penduduk belum terdaftar"], 404);            

        // cek apakah user ini sudah melaporkan penduduk ini
        if(!empty($cekTransaksi))
            return response()->json(['msg'=>"kamu sudah melaporkan penduduk ini"], 409);            

        if(
            empty($cekLantai) ||
            empty($cekDinding) ||
            empty($cekKondisiDinding) ||
            empty($cekAtap) ||
            empty($cekKondisiAtap)
        ){
            return response()->json(['msg'=>"ada yang tidak ada"], 404);            
        }

        // TODO remove nik from image
        $rumah   = "erukyah-transaksi-foto-depan-"    .now(). $cekPenduduk->nik . ".jpeg";
        $lantai  = "erukyah-transaksi-foto-lantai-"   .now(). $cekPenduduk->nik . ".jpeg";
        $dinding = "erukyah-transaksi-foto-dinding-"  .now(). $cekPenduduk->nik . ".jpeg";
        $atap    = "erukyah-transaksi-foto-atap-"     .now(). $cekPenduduk->nik . ".jpeg";

        $request->file("fotoDepan")         ->storeAs( "public/transaksi", $rumah );
        $request->file("fotoLantai")        ->storeAs( "public/transaksi", $lantai );
        $request->file("fotoDinding")       ->storeAs( "public/transaksi", $dinding );
        $request->file("fotoAtap")          ->storeAs( "public/transaksi", $atap );

        $transaksi = Transaksi::create([
            "nokk"              => $cekPenduduk->nokk,
            "nik"               => $request->nik,
            "latitude"          => $request->latitude,
            "longtitude"        => $request->longtitude,
            "fotoDepan"         => $rumah,
            "fotoLantai"        => $lantai,
            "fotoDinding"       => $dinding,
            "fotoAtap"          => $atap,
            "idLantai"          => $cekLantai->idLantai,
            "idDinding"         => $cekDinding->idDinding,
            "idKondisiDinding"  => $cekKondisiDinding->idKondisiDinding,
            "idAtap"            => $cekAtap->idAtap,
            "idKondisiAtap"     => $cekKondisiAtap->idKondisiAtap,
            "idUser"            => Auth::user()->idUser,
        ]);

        $rtransaksi = Transaksi::with([
            "lantai", 
            "dinding", 
            "kondisiDinding", 
            "atap", 
            "kondisiAtap",
            "user"
        ])->where("idTransaksi", $transaksi->idTransaksi)->first();

        return response()->json([
            "msg"   => "transaksi berhasil ditambahkan",
            "data"  => $rtransaksi
        ], 200);
    }

    public function show($id)
    {
        $transaksi = Transaksi::with([
            "lantai", 
            "dinding", 
            "kondisiDinding", 
            "atap", 
            "kondisiAtap",
            "user"
        ])->where("idTransaksi", $id)->first();

        if(empty($transaksi))
            return response()->json([ "msg"   => "data transaksi tidak ada", ], 404);
        
        return response()->json([
            "msg"   => "transaksi berhasil ditampilkan",
            "data"  => $transaksi
        ], 200);
    }

    public function update($id)
    {
        $transaksi = Transaksi::where("id", $id)->first();

        if(empty($transaksi))
            return response()->json([ "msg"   => "data transaksi tidak ada", ], 404);
        
        // =========================
        $validator = Validator::make($request->all(), [
            "nokk"              => "required",
            "nik"               => "required",
            "latitude"          => "required",
            "longtitude"        => "required",
            "fotoDepan"         => "required",
            "fotoLantai"        => "required",
            "fotoDinding"       => "required",
            "fotoAtap"          => "required",
            "idLantai"          => "required",
            "idDinding"         => "required",
            "idKondisiDinding"  => "required",
            "idAtap"            => "required",
            "idKondisiAtap"     => "required",
        ]);

        if ($validator->fails())
            return response()->json(['error'=>$validator->errors()], 401);            

        // validasi keadaan lokasi
        $cekPenduduk        = Penduduk::where("nokk",                   $request->nokk)->first();
        $cekLantai          = Lantai::where("idLantai",                 $request->idLantai)->first();
        $cekDinding         = Dinding::where("idDinding",               $request->idDinding)->first();
        $cekKondisiDinding  = KondisiDinding::where("idKondisiDinding", $request->idKondisiDinding)->first();
        $cekAtap            = Atap::where("idAtap",                     $request->idAtap)->first();
        $cekKondisiAtap     = KondisiAtap::where("idKondisiAtap",       $request->idKondisiAtap)->first();

        if(empty($cekPenduduk))
            return response()->json(['msg'=>"nokk penduduk belum terdaftar"], 404);            

        if($cekPenduduk->idUser != Auth::user()->idUser)
            return response()->json(['msg'=>"halaman terlarang"], 403);            

        if(
            empty($cekLantai) ||
            empty($cekDinding) ||
            empty($cekKondisiDinding) ||
            empty($cekAtap) ||
            empty($cekKondisiAtap)
        ){
            return response()->json(['msg'=>"ada yang tidak ada"], 404);            
        }

        // TODO remove nik from image
        $rumah   = "erukyah-transaksi-foto-depan-"    .now(). $cekPenduduk->nik . ".jpeg";
        $lantai  = "erukyah-transaksi-foto-lantai-"   .now(). $cekPenduduk->nik . ".jpeg";
        $dinding = "erukyah-transaksi-foto-dinding-"  .now(). $cekPenduduk->nik . ".jpeg";
        $atap    = "erukyah-transaksi-foto-atap-"     .now(). $cekPenduduk->nik . ".jpeg";

        $request->file("fotoDepan")         ->storeAs( "public/transaksi", $rumah );
        $request->file("fotoLantai")        ->storeAs( "public/transaksi", $lantai );
        $request->file("fotoDinding")       ->storeAs( "public/transaksi", $dinding );
        $request->file("fotoAtap")          ->storeAs( "public/transaksi", $atap );

        $transaksi->update([
            "nokk"              => $cekPenduduk->nokk,
            "nik"               => $request->nik,
            "latitude"          => $request->latitude,
            "longtitude"        => $request->longtitude,
            "fotoDepan"         => $rumah,
            "fotoLantai"        => $lantai,
            "fotoDinding"       => $dinding,
            "fotoAtap"          => $atap,
            "idLantai"          => $cekLantai->idLantai,
            "idDinding"         => $cekDinding->idDinding,
            "idKondisiDinding"  => $cekKondisiDinding->idKondisiDinding,
            "idAtap"            => $cekAtap->idAtap,
            "idKondisiAtap"     => $cekKondisiAtap->idKondisiAtap,
        ]);

    }
}
