<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Auth;

class UserController extends Controller
{
    public function index()
    {
        $user = User::paginate(15);

        return response()->json([
            "msg" => "data pengguna ditampilkan",
            "data" => $user 
        ]);
    }

    public function show()
    {
        $user = User::where("idUser", Auth::user()->idUser)->first();

        if($user == null) return response()->json([ "msg" => "data pengguna tidak ada"], 404);

        return response()->json([
            "msg" => "data pengguna ditampilkan",
            "data" => $user 
        ]);
    }
}
