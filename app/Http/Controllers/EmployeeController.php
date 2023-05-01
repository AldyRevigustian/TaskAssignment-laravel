<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = User::where('role', 'user')->get();
        return view('employee', compact('employees'));
    }

    public function store(Request $request)
    {
        $user = User::create([
            'name'  => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        $imageName = 'profile/' . time() . '.' . $request->photo->extension();
        Storage::disk('public')->put($imageName, file_get_contents($request->photo));

        $user->update([
            'photo' => 'storage/' . $imageName
        ]);

        return redirect()->route('employee')->with('status', 'success')->with('message', 'Sukses menambahkan data');
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

        return redirect()->route('employee')->with('status', 'success')->with('message', 'Sukses mengedit employee');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();

            return redirect()->route('employee')->with('status', 'success')->with('message', 'Sukses menghapus employee');
        }
    }
}
