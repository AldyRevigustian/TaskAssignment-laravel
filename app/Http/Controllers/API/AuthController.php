<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    function __construct()
    {
        $expired = Task::where('assigned_date', '<', Carbon::today())->get();
        foreach ($expired as $ex) {
            $ex->update([
                'status' => 'Incomplete'
            ]);
        }
        return;
    }

    public function login(Request $request)
    {
        $attrs = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if (!Auth::attempt($attrs)) {
            return response([
                'message' => 'Invalid credentials.'
            ], 403);
        }

        /** @var \App\Models\MyUserModel $user **/
        $user = Auth::user();
        $token = $user->createToken('token')->plainTextToken;

        $userData = [];

        foreach (array($user) as $d) {
            $data_change['id'] = $d->id;
            $data_change['name'] = $d->name;
            $data_change['email'] = $d->email;
            $data_change['photo'] = $d->photo;
            $data_change['role'] = $d->role;
            $data_change['registration'] = $d->registration;
            $data_change['token'] = $token;
            $userData = $data_change;
        }

        return response()->json($userData);
    }

    public function registration(Request $request)
    {
        $data = User::where('id', $request->id)->firstOrFail();

        $request->validate([
            'registration' => 'required'
        ]);

        $data->registration = $request->registration;
        $data->update();

        return response()->json(['success' => 'true', 'message' => 'Berhasil Menambahkan registrationIds', 'data' => $data]);
    }
}
