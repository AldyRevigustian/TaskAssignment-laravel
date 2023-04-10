<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Schedule;
use App\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Task::orderBy('updated_at', 'DESC')->whereDate('assigned_date', Carbon::today())->get();
        $day = Carbon::today()->format('d-m-Y');
        $today = Carbon::today();
        $tasks = Task::all();
        return view('dashboard', compact('data', 'day', 'today', 'tasks'));
    }
}
