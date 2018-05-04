<?php

namespace App\Http\Controllers;

use App\Ad;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

class AdController extends Controller
{
    use ValidatesRequests;

    public function index()
    {
        $ads = Ad::with('platforms')->get();
        return view('pages.ads.list', compact('ads'));
    }

    public function create()
    {
        return view('pages.ads.create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'img_url' => 'required',
            'price' => 'required|numeric',
        ]);

        Ad::create($validatedData);

        return redirect()->route('ads');
    }
}
