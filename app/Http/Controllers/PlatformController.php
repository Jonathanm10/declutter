<?php

namespace App\Http\Controllers;

use App\Platform;
use App\Platforms\PlatformInterface;
use Illuminate\Http\Request;

class PlatformController extends Controller
{
    public function index()
    {
        $platforms = Platform::all();
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

        $platform = Platform::whereId($id)->first();
        $platform->config = array_merge($platform->config, $validatedData);
        $platform->update();

        return redirect()->route('platforms');
    }

    /**
     * @param Platform $platform
     * @return PlatformInterface
     */
    protected function getHelperClassFromPlatform(Platform $platform)
    {
        $platformType = $platform->type;
        $class = "App\Platforms\\$platformType\\$platformType";

        return new $class();
    }
}
