<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Schedule;
use Carbon\Carbon;
use Storage;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $tasks = Task::where('assigned_date', date('Y-m-d'))->get();
        $date = date('Y-m-d');

        if ($request->filter) {
            $tasks = Task::where('assigned_date', $request->filter)->get();
            $date = $request->filter;
        }

        return view('history.index', compact('tasks', 'date'));
    }

    public function destroy($id)
    {
        $data = Task::find($id);
        // if($data->upload_bukti){
        //     Storage::delete('/bukti/'.$data->upload_bukti);
        // }
        $data->delete();
        return redirect()->route('history')->with('status', 'success')->with('message', 'Sukses menghapus task');
    }
}
