<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penduduk;
use App\Models\Desa;
use App\Models\Kecamatan;
use App\Models\Kabupaten;
use App\Models\Provinsi;
use App\Models\Transaksi;
use App\Models\User;
use Auth;
use Validator;

class PendudukController extends Controller
{
    public function index()
    {
        $penduduk = Penduduk::with(["provinsi", "kabupaten" ,"kecamatan", "desa", "user"])->paginate(15);
        
        return response()->json([
            "msg"       => "penduduk berhasil ditampilkan",
            "data"      => $penduduk,
        ]);
    }

    public function home()
    {
        $penduduk = Penduduk::with(["provinsi", "kabupaten" ,"kecamatan", "desa", "user"])->take(10)->get();

        $transaksi = [];
        foreach($penduduk as $a){
            $b = Transaksi::where("nokk", $a->nokk)->exists();
            $c = Transaksi::with([
                "lantai", "dinding", "kondisiDinding", 
                "atap", "kondisiAtap", "user" ])->where("nokk", $a->nokk)->get();
            $hasil = 0; // inisialisasi hasil
            if($b){
                $i = 1; // inisialisasi jumlah pelapor
                foreach($c as $d){
                    $lantai         = $d->lantai->skorLantai;
                    $atap           = $d->atap->skorAtap;
                    $kondisiAtap    = $d->kondisiAtap->skorKondisiAtap;
                    $dinding        = $d->dinding->skorDinding;
                    $kondisiDinding = $d->kondisiDinding->skorKondisiDinding;
                    $hasil          += $lantai + $atap + $kondisiAtap + $dinding + $kondisiDinding;
                }
            }
            array_push($transaksi, $hasil);
        }

        
        
        return response()->json([
            "msg"       => "penduduk berhasil ditampilkan",
            "data"      => [
                "penduduk"  => $penduduk,
                "transaksi" => $transaksi,
            ],
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "nokk"          => "required|digits:16",
            "nik"           => "required|digits:16",
            "nama"          => "required",
            "alamat"        => "required",
            "latitude"      => "required",
            "longtitude"    => "required",
            "idDesa"        => "required",
            "idKecamatan"   => "required",
            "idKabupaten"   => "required",
            "idProvinsi"    => "required",
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        // get id wilayah
        $idDesa      = Desa::select("idDesa")->where("idDesa",                   $request->idDesa)->first();
        $idKecamatan = Kecamatan::select("idKecamatan")->where("idKecamatan",    $request->idKecamatan)->first();
        $idKabupaten = Kabupaten::select("idKabupaten")->where("idKabupaten",    $request->idKabupaten)->first();
        $idProvinsi  = Provinsi::select("idProvinsi")->where("idProvinsi",       $request->idProvinsi)->first();

        if ( empty($idDesa) || empty($idKecamatan) || empty($idKabupaten) || empty($idProvinsi) )
            return response()->json(["msg" => "data wilayah tidak ditemukan"], 404);

        // cek exist or no data penduduk
        $cekPenduduk = Penduduk::where("nokk", $request->nokk)->first();
        if ( !empty($cekPenduduk) )
            return response()->json(["msg" => "nokk sudah terdaftar"], 409);
    
        // store to penduduk
        $penduduk = Penduduk::create([
            "nokk"          => $request->nokk,
            "nik"           => $request->nik,
            "nama"          => $request->nama,
            "alamat"        => $request->alamat,

            "latitude"      => $request->latitude,
            "longtitude"    => $request->longtitude,

            "idDesa"        => $request->idDesa,
            "idKecamatan"   => $request->idKecamatan,
            "idKabupaten"   => $request->idKabupaten,
            "idProvinsi"    => $request->idProvinsi,
            "idUser"        => Auth::user()->idUser,
        ]);
    

        return response()->json([
            "msg"   => "penduduk berhasil ditambahkan",
            "data"  => $penduduk->id
        ], 200);
    }

    public function show($id)
    {
        $penduduk = Penduduk::with(["desa", "kecamatan", "kabupaten", "provinsi", "user"])->where("idPenduduk", $id)->first();
        if ($penduduk == null) return response()->json(["msg" => "penduduk tidak ditemukan"], 404);

        $transaksi = Transaksi::with([
            "lantai", 
            "dinding", 
            "kondisiDinding", 
            "atap", 
            "kondisiAtap",
            "user"
        ])->where("nokk", $penduduk->nokk)->get();
        return response()->json([
            "msg" => "data penduduk berhasil ditampilkan",
            "data"=> [
                "penduduk"  => $penduduk, 
                "transaksi" => $transaksi
            ],
        ], 200);
    }

    // edit dilakukan jika belum ada row transaksi / kecuali admin tertinggi / kimpraswil
    // renovasi
    public function edit($id)
    {
        $penduduk = Penduduk::with("desa", "kecamatan", "kabupaten", "provinsi")->where("idPenduduk", $id)->first();
        if ($penduduk == null) return response()->json(["msg" => "penduduk tidak ditemukan"], 404);

        $validator = Validator::make($request->all(), [
            "nokk"          => "required|digits:16",
            "nik"           => "required|digits:16",
            "nama"          => "required",
            "alamat"        => "required",
            "latitude"      => "required",
            "longtitude"    => "required",
            "status"        => "in:0,1",
            "idDesa"        => "required",
            "idKecamatan"   => "required",
            "idKabupaten"   => "required",
            "idProvinsi"    => "required",
        ]);

        if ($validator->fails()) 
            return response()->json(['error'=>$validator->errors()], 401);            

        // validate , if user != yang menulis atau seorang admin , maka tidak boleh
        if($penduduk->idUser != Auth::user()->idUser)
            return response(["msg" => "Halaman Terlarang"] , 403);

         // get id wilayah
         $idDesa      = Desa::select("idDesa")->where("idDesa",                   $request->idDesa)->first();
         $idKecamatan = Kecamatan::select("idKecamatan")->where("idKecamatan",    $request->idKecamatan)->first();
         $idKabupaten = Kabupaten::select("idKabupaten")->where("idKabupaten",    $request->idKabupaten)->first();
         $idProvinsi  = Provinsi::select("idProvinsi")->where("idProvinsi",       $request->idProvinsi)->first();
 
         if ( empty($idDesa) || empty($idKecamatan) || empty($idKabupaten) || empty($idProvinsi) )
             return response()->json(["msg" => "data wilayah tidak ditemukan"], 404);
 
         // store to penduduk
         $penduduk->update([
             "nokk"          => $request->nokk,
             "nik"           => $request->nik,
             "nama"          => $request->nama,
             "alamat"        => $request->alamat,
             "status"        => $request->status,

             "idDesa"        => $request->idDesa,
             "idKecamatan"   => $request->idKecamatan,
             "idKabupaten"   => $request->idKabupaten,
             "idProvinsi"    => $request->idProvinsi,
         ]);
 
         return response()->json([
             "msg"   => "penduduk berhasil diedit",
             "data"  => $penduduk
         ], 200);
    }

    public function renovasi(Request $request, $id)
    {
        // cek keadaan data penduduk
        $penduduk = Penduduk::with("desa", "kecamatan", "kabupaten", "provinsi")->where("idPenduduk", $id)->first();
        if ($penduduk == null) return response()->json(["msg" => "penduduk tidak ditemukan"], 404);

        if($penduduk->status == 2) return response()->json(["msg" => "penduduk sudah direnovasi"], 409);

        // tambahan id yang merenovasi
        $validator = Validator::make($request->all(), [
            "nokk"          => "required|digits:16",
            "nik"           => "required|digits:16",
            "nama"          => "required",
            "alamat"        => "required",
            "latitude"      => "required",
            "longtitude"    => "required",
            // "status"        => "in:0,1",

            "tglPerbaikan"          => "required", // validate date
            "noKontrak"             => "required", // validate number
            "fotoRumahPerbaikan"    => "mimes:jpeg,png",
            "fotoLantai"            => "mimes:jpeg,png",
            "fotoDinding"           => "mimes:jpeg,png",
            "fotoAtap"              => "mimes:jpeg,png",
            
            "idDesa"        => "required",
            "idKecamatan"   => "required",
            "idKabupaten"   => "required",
            "idProvinsi"    => "required",
        ]);

        if ($validator->fails()) 
            return response()->json(['error'=>$validator->errors()], 401);            

        // get id wilayah
        $idDesa      = Desa::select("idDesa")->where("idDesa",                   $request->idDesa)->first();
        $idKecamatan = Kecamatan::select("idKecamatan")->where("idKecamatan",    $request->idKecamatan)->first();
        $idKabupaten = Kabupaten::select("idKabupaten")->where("idKabupaten",    $request->idKabupaten)->first();
        $idProvinsi  = Provinsi::select("idProvinsi")->where("idProvinsi",       $request->idProvinsi)->first();

        if ( empty($idDesa) || empty($idKecamatan) || empty($idKabupaten) || empty($idProvinsi) )
            return response()->json(["msg" => "data wilayah tidak ditemukan"], 404);
 
        // TODO remove nik from image
        $rumah   = "erukyah-renovasi-rumah-"    .now(). $penduduk->nik . ".docx";
        $lantai  = "erukyah-renovasi-lantai-"   .now(). $penduduk->nik . ".docx";
        $dinding = "erukyah-renovasi-dinding-"  .now(). $penduduk->nik . ".docx";
        $atap    = "erukyah-renovasi-atap-"     .now(). $penduduk->nik . ".docx";

        $request->file("fotoRumahPerbaikan")->storeAs( "public/renovasi", $rumah );
        $request->file("fotoLantai")        ->storeAs( "public/renovasi", $lantai );
        $request->file("fotoDinding")       ->storeAs( "public/renovasi", $dinding );
        $request->file("fotoAtap")          ->storeAs( "public/renovasi", $atap );

         // store to penduduk
         $penduduk->update([
            "nokk"          => $request->nokk,
            "nik"           => $request->nik,
            "nama"          => $request->nama,
            "alamat"        => $request->alamat,
            "status"        => 2, //kode renvasi

            "tglPerbaikan"          => $request->tglPerbaikan,
            "noKontrak"             => $request->noKontrak,
            "fotoRumahPerbaikan"    => $rumah,
            "fotoLantai"            => $lantai,
            "fotoDinding"           => $dinding,
            "fotoAtap"              => $atap,

            "idDesa"        => $request->idDesa,
            "idKecamatan"   => $request->idKecamatan,
            "idKabupaten"   => $request->idKabupaten,
            "idProvinsi"    => $request->idProvinsi,
         ]);
 
         return response()->json([
             "msg"   => "rumah penduduk berhasil direnovasi",
             "data"  => $penduduk
         ], 200);
    }

    // for admin only
    public function destroy($id)
    {
        $penduduk = Penduduk::where("idPenduduk", $id)->first();
        if($penduduk == null)
            return response()->json(["msg" => "penduduk tidak ditemukan"], 404);
        $penduduk->delete();
        Transaksi::where("id", $penduduk->nokk)->delete();

        return response()->json(["msg" => "penduduk berhasil dihapus"], 200);
    }
}