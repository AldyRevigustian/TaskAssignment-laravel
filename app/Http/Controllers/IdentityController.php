<?php

namespace App\Http\Controllers;

use App\Models\Identity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IdentityController extends Controller
{

    public function index()
    {
        $identity = Identity::first();

        return view('identity', compact('identity'));
    }


    public function update(Request $request, Identity $identity)
    {
        $identity = Identity::first();

        $identity->update([
            'app_name' => $request->app_name ?? $identity->app_name,
            'company_name' => $request->company_name ?? $identity->company_name,
            'app_authorization' => $request->app_authorization ?? $identity->app_authorization,
            'app_mobile_name' => $request->app_mobile_name ?? $identity->app_mobile_name
        ]);

        if ($request->app_logo) {
            $imageName = 'logo/' . time() . '.' . $request->app_logo->extension();
            Storage::disk('public')->put($imageName, file_get_contents($request->app_logo));

            $identity->update([
                'app_logo' => 'storage/' . $imageName
            ]);
        }

        return redirect()->route('identity')->with('status', 'success')->with('message', 'Sukes mengedit identitas aplikasi');
    }
}
