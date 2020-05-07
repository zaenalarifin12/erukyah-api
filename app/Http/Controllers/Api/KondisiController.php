<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lantai;
use App\Models\Atap;
use App\Models\KondisiAtap;
use App\Models\Dinding;
use App\Models\KondisiDinding;

class KondisiController extends Controller
{
    public function lantai()
    {
        $lantai = Lantai::get();

        return response()->json(["data" => $lantai]);
    }

    public function atap()
    {
        $atap = Atap::get();

        return response()->json(["data" => $atap]);
    }

    public function kondisiAtap()
    {
        $kondisiAtap = KondisiAtap::get();

        return response()->json(["data" => $kondisiAtap]);
    }

    public function dinding()
    {
        $dinding = Dinding::get();

        return response()->json(["data" => $dinding]);
    }

    public function kondisiDinding()
    {
        $kondisiDinding = KondisiDinding::get();

        return response()->json(["data" => $kondisiDinding]);
    }
}
