<?php

namespace App\Http\Controllers;

use App\Ad;
use App\Platform;
use App\Platforms\Traits\GetHelperClassFromPlatform;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class PlatformController extends Controller
{
    use GetHelperClassFromPlatform;

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $platforms = Platform::with('ads')->get();
        return view('pages.platforms.list', compact('platforms'));
    }

    /**
     * @param Platform $platform
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Platform $platform)
    {
        $helper = $this->getHelperClassFromPlatform($platform);
        $formFields = $helper->getFormFields();

        return view('pages.platforms.edit', compact('platform', 'formFields'));
    }

    /**
     * @param Request $request
     * @param Platform $platform
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Platform $platform)
    {
        $helper = $this->getHelperClassFromPlatform($platform);
        $validatedData = $request->validate($helper->getFormFieldsValidationRules());

        if (array_key_exists('password', $validatedData)) {
            $validatedData['password'] = Crypt::encrypt($validatedData['password']);
        }

        $updatedConfig = array_merge(/** @scrutinizer ignore-type */  $platform->config, $validatedData);
        $platform->config = $updatedConfig;
        $platform->save();

        return redirect()->route('platforms.list');
    }

    /**
     * @param Request $request
     * @param Platform $platform
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeConfiguration(Request $request, Platform $platform)
    {
        $adsPublishedOnPlatform = $platform->ads;
        $helper = $this->getHelperClassFromPlatform($platform);

        try {
            if (count($adsPublishedOnPlatform) > 0) {
                $adsPublishedOnPlatform->each(function(Ad $ad) use ($platform, $helper) {
                    $helper->unpublish($ad, $platform);
                    $ad->platforms()->detach($platform->id);
                });
            }

            $emptyConfig = collect($helper->getFormFields())->reduce(function($emptyConfig, $field) {
                $emptyConfig[$field['name']] = '';
                return $emptyConfig;
            }, []);

            $platform->config = $emptyConfig;
            $platform->save();

            $request->session()->flash('success', 'Configuration de la plateforme supprimée');
        } catch (\Exception $e) {
            $request->session()->flash('danger', $e->getMessage());
        }

        return redirect()->route('platforms.list');
    }
}
