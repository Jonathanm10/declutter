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
     * @param Ad $ad
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Ad $ad)
    {
        return view('pages.ads.edit', compact('ad'));
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
    public function update(Request $request, Ad $ad)
    {
        $validatedData = $request->validate($this->formRules);

        $ad->update($validatedData);

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
     * @param Ad $ad
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function delete(Request $request, Ad $ad)
    {
        $publishedPlatforms = $ad->platforms;

        if (count($publishedPlatforms) > 0) {
            try {
                $publishedPlatforms->each(function ($platform) use ($ad) {
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
     * @param Ad $ad
     * @param Platform $platform
     * @return \Illuminate\Http\RedirectResponse
     */
    public function togglePublish(Request $request, Ad $ad, Platform $platform)
    {
        $platformHelper = $this->getHelperClassFromPlatform($platform);
        $isPublished = $ad->platforms()->where('platform_id', $platform->id)->first() !== null;

        try {
            if ($isPublished) {
                $platformHelper->unpublish($ad, $platform);
                $ad->platforms()->detach($platform->id);
            } else {
                $publicationItemId = $platformHelper->publish($ad, $platform);
                $ad->platforms()->attach($platform->id, ['publication_item_id' => $publicationItemId]);
            }
            $request->session()->flash('success', 'Annonce mise à jour');
        } catch (\Exception $e) {
            $request->session()->flash('danger', $e->getMessage());
        }

        return redirect()->route('ads.list');
    }
}
