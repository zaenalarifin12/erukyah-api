<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Berita;
use Validator;
use Auth;

class BeritaController extends Controller
{
    
    public function index()
    {
        $berita = Berita::paginate(15);

        return response()->json([
            "msg"   => "menampilkan data bertia",
            "data"  => $berita
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "judulBerita"   => "required",
            "uraianBerita"  => "required",
            "fileBerita"    => "mime:docx,doc",
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $slug = Str::slug($request->judulBerita);
        $selectBerita = Berita::where("slugBerita", $slug)->first();
        if ($selectBerita != null) 
            $slug = Str::slug($slug.now());

        $name = "erukyah-berita-".now()."-slug.docx";

        $file = $request->file("fileBerita")->storeAs(
            "public/berita", $name
        );
        
        $berita = Berita::create([
            "judulBerita"   => $request->judulBerita,
            "slugBerita"   => $slug,
            "uraianBerita"  => $request->uraianBerita,
            "fileBerita"    => $name,
            "idUser"        => Auth::user()->idUser
        ]);

        return response()->json([ "data" => $berita ], 201);
    }

    public function show($slug)
    {
        $berita = Berita::where("slugBerita", $slug)->first();
        
        if($berita == null)
            return response()->json(["error" => "berita tidak ditemukan"], 404);

        return response()->json([ "data" => $berita ], 200);
    }

    /**
     * TODO berita belum fix , masih bug direquest
     */
    public function update(Request $request, $slug)
    {
        
        dd($request->all());
        $validator = Validator::make($request->all(), [
            "judulBerita" => "required",
            "uraianBerita"  => "required",
            "fileBerita"    => "mime:docx,doc",
        ]);

        $berita = Berita::where("slugBerita", $slug)->first();
        
        if($berita == null)
            return response()->json(["error" => "berita tidak ditemukan"], 404);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $name = "erukyah-berita-".now()."-slug.docx";

        $file = $request->file("fileBerita")->storeAs(
            "public/berita", $name
        );
        
        $berita->update([
            "judulBerita"   => $request->judulBerita,
            "uraianBerita"  => $request->uraianBerita,
            "fileBerita"    => $name,
            "idUser"        => Auth::user()->idUser
        ]);

        return response()->json([ 
            "data"  => $berita,
            "msg"   => "berita berhasil diubah"
         ], 200);
    }

    public function destroy($slug)
    {
        $berita = Berita::where("slugBerita", $slug)->first();

        if($berita == null) return response()->json(["msg" => "berita tidak ditemukan"],404);

        $berita->delete();
        return response()->json(["msg" => "berita berhasil dihapus"], 200);
    }
}
