<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class DailyScrumController extends Controller
{
    public function daily() {
        $data = "Data All Daily";
        return response()->json($data, 200);
    }

    public function dailyAuth() {
        $data = "Welcome " . Auth::user()->name;
        return response()->json($data, 200);
    }
}

