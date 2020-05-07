<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post("/register", "Api\AuthController@register");
Route::post("/login", "Api\AuthController@login");

Route::group(["middleware" => ["auth:api"]], function(){
    // ======== BERITA ===========
    Route::get("/berita",           "Api\BeritaController@index");
    Route::post("/berita",          "Api\BeritaController@store");
    Route::get("/berita/{slug}",    "Api\BeritaController@show");
    Route::put("/berita/{slug}",    "Api\BeritaController@update");
    Route::delete("/berita/{slug}", "Api\BeritaController@destroy");

    // ========== USERS ==============
    // TODO LEVEL 1 ONLY
    Route::get("/users",            "Api\UserController@index");
    Route::get("/users/{id}",       "Api\UserController@show");

    // ============ PENDUDUK =============
    Route::get("/penduduk",                 "Api\PendudukController@index");
    Route::get("/penduduk/home",                 "Api\PendudukController@home");
    Route::post("/penduduk",                "Api\PendudukController@store");
    Route::get("/penduduk/{id}",            "Api\PendudukController@show");
    Route::put("/penduduk/{id}",            "Api\PendudukController@update");
    Route::delete("/penduduk/{id}",         "Api\PendudukController@destroy");
    Route::post("/penduduk/renovasi/{id}",   "Api\PendudukController@renovasi");

    // ============ PENDUDUK =============
    Route::get("/transaksi",        "Api\TransaksiController@index");
    Route::post("/transaksi",       "Api\TransaksiController@store");
    Route::get("/transaksi/{id}",   "Api\TransaksiController@show");
    // Route::put("/transaksi/{id}",   "Api\UserController@show");
    // Route::delete("/transaksi/{id}",   "Api\UserController@show");

    // ==========
});
Route::get("/lantai",               "Api\KondisiController@lantai");
Route::get("/atap",                 "Api\KondisiController@atap");
Route::get("/dinding",              "Api\KondisiController@dinding");
Route::get("/kondisi-atap",         "Api\KondisiController@kondisiAtap");
Route::get("/kondisi-dinding",      "Api\KondisiController@kondisiDinding");


Route::get("/provinsi",                                                 "Api\LokasiController@provinsi");
Route::get("/provinsi/{idProvinsi}/kabupaten",                          "Api\LokasiController@kabupaten");
Route::get("/provinsi/kabupaten/{idKabupaten}/kecamatan",               "Api\LokasiController@kecamatan");
Route::get("/provinsi/kabupaten/kecamatan/{idKecamatan}/desa",          "Api\LokasiController@desa");


// ========= for get lokasi
// Route::get("/provinsi",       "Api\Lokasi\GetApiLokasiController@getProvinsi");
// Route::get("/kabupaten",      "Api\Lokasi\GetApiLokasiController@getKabupaten");
// Route::get("/kecamatan",      "Api\Lokasi\GetApiLokasiController@getKecamatan");
// Route::get("/desa",           "Api\Lokasi\GetApiLokasiController@getDesa");

// Route::get("/test-provinsi",       "Api\Lokasi\CekLokasiController@provinsi");
// Route::get("/test-kabupaten",      "Api\Lokasi\CekLokasiController@kabupaten");
// Route::get("/test-kecamatan",      "Api\Lokasi\CekLokasiController@kecamatan");
// Route::get("/test-desa",           "Api\Lokasi\CekLokasiController@desa");
