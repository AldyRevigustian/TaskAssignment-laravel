<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Schedule;
use Carbon\Carbon;
use Storage;

class HistoryController extends Controller
{
    public function cek_expired()
    {
        $expired = Task::where('assigned_date', '<', Carbon::today())->get();
        foreach ($expired as $ex) {
            $ex->update([
                'status' => 'Incomplete'
            ]);
        }
        return;
    }

    public function index(Request $request)
    {
        $this->cek_expired();
        $tasks = Task::whereDate('assigned_date', date('Y-m-d'))->where('status', '!=', 'On Progress')->get();
        $date = date('Y-m-d');
        if ($request->filter) {
            $tasks = Task::whereDate('assigned_date', $request->filter)->get();
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
