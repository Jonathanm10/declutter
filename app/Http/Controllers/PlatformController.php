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

        $updatedConfig = array_merge($platform->config, $validatedData);
        $platform->config = $updatedConfig;
        $platform->save();

        return redirect()->route('platforms.list');
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
