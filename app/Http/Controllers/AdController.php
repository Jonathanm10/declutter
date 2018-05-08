<?php

namespace App\Http\Controllers;

use App\Ad;
use App\Platform;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

class AdController extends Controller
{
    use ValidatesRequests;

    protected $formRules = [
        'title' => 'required|max:255',
        'description' => 'required',
        'img_url' => 'required',
        'price' => 'required|numeric',
    ];

    public function index()
    {
        $ads = Ad::with('platforms')->get();
        $platforms = Platform::all();
        return view('pages.ads.list', compact('ads', 'platforms'));
    }

    public function edit($id)
    {
        return view('pages.ads.edit', ['ad' => Ad::findOrFail($id)]);
    }

    public function create()
    {
        return view('pages.ads.create');
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate($this->formRules);

        Ad::whereId($id)->update($validatedData);

        return redirect()->route('ads.list');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate($this->formRules);

        Ad::updateOrCreate($validatedData->id, $validatedData);

        return redirect()->route('ads.list');
    }

    public function delete($id)
    {
        $ad = Ad::find($id);
        $ad->delete();
        return redirect()->route('ads.list');
    }
}
