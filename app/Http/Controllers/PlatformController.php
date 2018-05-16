<?php

namespace App\Http\Controllers;

use App\Ad;
use App\Platform;
use App\Platforms\Traits\GetHelperClassFromPlatform;
use Illuminate\Http\Request;

class PlatformController extends Controller
{
    use GetHelperClassFromPlatform;

    public function index()
    {
        $platforms = Platform::with('ads')->get();
        return view('pages.platforms.list', compact('platforms'));
    }

    public function edit($id)
    {
        $platform = Platform::find($id);
        $helper = $this->getHelperClassFromPlatform($platform);
        $formFields = $helper->getFormFields();

        return view('pages.platforms.edit', compact('platform', 'formFields'));
    }

    public function update(Request $request, $id)
    {
        $platform = Platform::find($id);
        $helper = $this->getHelperClassFromPlatform($platform);
        $validatedData = $request->validate($helper->getFormFieldsValidationRules());

        $updatedConfig = array_merge($platform->config, $validatedData);
        $platform->config = $updatedConfig;
        $platform->save();

        return redirect()->route('platforms.list');
    }

    public function removeConfiguration(Request $request, $id)
    {
        $platform = Platform::find($id);
        $adsPublishedOnPlatform = $platform->ads()->where('platform_id', $id)->get();
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
