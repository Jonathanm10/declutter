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

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $ads = Ad::with('platforms')->get();
        $platforms = Platform::all();
        return view('pages.ads.list', compact('ads', 'platforms'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        return view('pages.ads.edit', ['ad' => Ad::findOrFail($id)]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('pages.ads.create');
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
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

        Ad::create($validatedData);

        return redirect()->route('ads.list');
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request, $id)
    {
        $ad = Ad::find($id);

        $publishedAds = $ad->platforms()->where('ad_id', $id)->get();

        if ($publishedAds) {
            try {
                $publishedAds->each(function ($platform) use ($ad) {
                    $platformHelper = $this->getHelperClassFromPlatform($platform);
                    $platformHelper->unpublish($ad, $platform);
                    $ad->platforms()->detach($platform->id);
                });
            } catch (\Exception $e) {
                $request->session()->flash('danger', $e->getMessage());
                return redirect()->route('ads.list');
            }
        }

        $ad->delete();
        $request->session()->flash('success', 'Annonce supprimée');
        return redirect()->route('ads.list');
    }

    /**
     * @param Request $request
     * @param $id
     * @param $platformId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function togglePublish(Request $request, $id, $platformId)
    {
        $platform = Platform::find($platformId);
        $ad = Ad::find($id);

        $platformHelper = $this->getHelperClassFromPlatform($platform);
        $isPublished = $ad->platforms()->where('platform_id', $platformId)->first() !== null;

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
