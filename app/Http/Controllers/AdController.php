<?php

namespace App\Http\Controllers;

use App\Ad;
use Illuminate\Http\Request;

class AdController extends Controller
{
    public function index()
    {
        $ads = Ad::with('platforms')->get();
        return view('pages.ads', compact('ads'));
    }
}
