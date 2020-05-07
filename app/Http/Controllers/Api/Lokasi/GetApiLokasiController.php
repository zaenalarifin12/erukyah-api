<?php

namespace App\Http\Controllers\Api\Lokasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GetApiLokasiController extends Controller
{
    public function getProvinsi()
    {
        // initialize
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', "http://dev.farizdotid.com/api/daerahindonesia/provinsi", 
                [
                    "headers" => 
                        ["Accept" => "application/json",
                        "Content-type" => "application/json" ]
                ]);
                    
        // convert json to array
        $hasil = json_decode($res->getBody(), true);

        // mengambil data provinsi
        $provinsi = $hasil["semuaprovinsi"];


        foreach($provinsi as $key => $value)
        {
            DB::table("provinsi")->insert([
                "idProvinsi"    => $value["id"],
                "namaProvinsi"  => $value["nama"]
            ]);
        }

        $a = DB::table("provinsi")->get();
        dd("berhasil");

    }

    public function getKabupaten()
    {
        $client = new \GuzzleHttp\Client();

        $idProv = DB::table('provinsi')->select('idProvinsi')->get();

        foreach($idProv as $key => $value){
            
            $res = $client->request("GET", "http://dev.farizdotid.com/api/daerahindonesia/provinsi/". $value->idProvinsi . "/kabupaten", 
                [
                    "headers" => [
                        "Accept"        => "application/json",
                        "Content-type"  => "application/json"
                    ]
                ]
            );

            $hasil = json_decode($res->getBody(), true);
            $hasil = $hasil["kabupatens"];
            foreach($hasil as $key1 => $value1)
            {
                DB::table("kabupaten")->insert([
                    "idKabupaten"            => $value1["id"],
                    "namaKabupaten"          => $value1["nama"],
                    "idProvinsi"             => $value1["id_prov"]
                ]);
            }
        // end foreach
        }

        dd("berhasil");
    }

    public function getKecamatan()
    {
        $client = new \GuzzleHttp\Client();

        $idKab  = DB::table("kabupaten")->select("idKabupaten")->get();

        foreach($idKab as $key => $value)
        {
            $res = $client->request("GET", "http://dev.farizdotid.com/api/daerahindonesia/provinsi/kabupaten/". $value->idKabupaten . "/kecamatan", 
            [
                "headers" => [
                    "Accept"        => "application/json",
                    "Content-type"  => "application/json"
                ]
            ]
        );
        
        $hasil = json_decode($res->getBody(), true);
        $hasil = $hasil["kecamatans"];
        foreach($hasil as $key => $value){
                DB::table("kecamatan")->insert([
                    "idKecamatan"            => $value["id"],
                    "namaKecamatan"          => $value["nama"],
                    "idKabupaten"            => $value["id_kabupaten"]
                ]);
            }
        // end foreach
        }

        dd("berhasil");
    }

    public function getDesa()
    {
        $client = new \GuzzleHttp\Client();

        $idKab  = DB::table("kecamatan")->select("idKecamatan")->get();

        foreach($idKab as $key => $value)
        {
            $res = $client->request("GET", "http://dev.farizdotid.com/api/daerahindonesia/provinsi/kabupaten/kecamatan/". $value->idKecamatan . "/desa", 
            [
                "headers" => [
                    "Accept"        => "application/json",
                    "Content-type"  => "application/json"
                ]
            ]
        );
        
        $hasil = json_decode($res->getBody(), true);
        $hasil = $hasil["desas"];
        
        foreach($hasil as $key => $value){
                DB::table("desa")->insert([
                    "idDesa"            => $value["id"],
                    "namaDesa"          => $value["nama"],
                    "idKecamatan"       => $value["id_kecamatan"]
                ]);
            }
        // end foreach
        }

        dd("berhasil");
    }
}
