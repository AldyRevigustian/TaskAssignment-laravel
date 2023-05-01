<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
        $admins = User::where('role', 'admin')->get();
        return view('admin', compact('admins'));
    }

    public function store(Request $request)
    {
        $user = User::create([
            'name'  => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
        ]);

        $imageName = 'profile/' . time() . '.' . $request->photo->extension();
        Storage::disk('public')->put($imageName, file_get_contents($request->photo));

        $user->update([
            'photo' => 'storage/' . $imageName
        ]);

        return redirect()->route('admin')->with('status', 'success')->with('message', 'Sukses menambahkan data');
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->update([
            'name' => $request->name ?? $user->name,
        ]);

        if ($request->photo) {
            $imageName = 'profile/' . time() . '.' . $request->photo->extension();
            Storage::disk('public')->put($imageName, file_get_contents($request->photo));

            $user->update([
                'photo' => 'storage/' . $imageName
            ]);
        }

        return redirect()->route('admin')->with('status', 'success')->with('message', 'Sukses mengedit employee');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();

            return redirect()->route('admin')->with('status', 'success')->with('message', 'Sukses menghapus admin');
        }
    }
}
