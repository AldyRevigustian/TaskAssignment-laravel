<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;

class UserController extends Controller
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


    public function worker()
    {
        $data = User::where('role', 'user')->get();

        $data_fix = [];
        foreach ($data as $d) {
            $data_change['id'] = $d->id;
            $data_change['name'] = $d->name;
            $data_change['registration'] = $d->registration;
            $data_fix[] = $data_change;
        }
        return response()->json($data_fix);
    }

    public function admin()
    {
        $data = User::where('role', 'admin')->get();

        $data_fix = [];
        foreach ($data as $d) {
            $data_change['id'] = $d->id;
            $data_change['name'] = $d->name;
            $data_change['registration'] = $d->registration;
            $data_fix[] = $data_change;
        }
        return response()->json($data_fix);
    }
}
