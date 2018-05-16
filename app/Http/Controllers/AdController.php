<?php

namespace App\Http\Controllers;

use App\Ad;
use App\Platform;
use App\Platforms\Traits\GetHelperClassFromPlatform;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

class AdController extends Controller
{
    use ValidatesRequests;
    use GetHelperClassFromPlatform;

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

    public function togglePublish(Request $request, $id, $platformId)
    {
        $platform = Platform::find($platformId);
        $ad = Ad::find($id);

        $platformHelper = $this->getHelperClassFromPlatform($platform);
        $isPublished = count($ad->platforms) > 0;

        try {
            if ($isPublished) {
                $platformHelper->unpublish($ad, $platform);
                $ad->platforms()->detach($platformId);
            } else {
                $publicationItemId = $platformHelper->publish($ad, $platform);
                $ad->platforms()->attach($platformId, ['publication_item_id' => $publicationItemId]);
            }
            $request->session()->flash('success', 'Annonce mise à jour');
        } catch (\Exception $e) {
            $request->session()->flash('danger', $e->getMessage());
        }

        return redirect()->route('ads.list');
    }
}
