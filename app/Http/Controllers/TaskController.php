<?php

namespace App\Http\Controllers;

use App\Models\Identity;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'user')->get();
        $tasks = Task::orderBy('assigned_date', 'ASC')
            ->where('status', 'On Progress')
            ->whereDate('assigned_date', '>=', Carbon::today())
            ->get();

        return view('task.index', compact('tasks', 'users'));
    }

    public function store(Request $request)
    {
        $date = date("Y-m-d H:i:s", strtotime($request->assigned_date));

        $identity = Identity::first();
        $client = new Client();
        $user = User::where('id', $request->user_id)->first();

        $task = Task::create([
            'task_title' => $request->task_title,
            'task_description' => $request->task_description,
            'user_id' => $request->user_id,
            'assigned_date' => $date,
        ]);


        if ($user->registration == null) {
            if ($task) {
                return redirect()->route('task')->with('status', 'success')->with('message', 'Sukses menambah task tanpa notifikasi');
            }
        }

        if ($task) {
            $response = $client->post('https://fcm.googleapis.com/fcm/send', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => $identity->app_authorization
                ],
                'json' => [
                    "registration_ids" => [
                        $user->registration
                    ],
                    "notification" => [
                        "title" => $request->task_title,
                        "body" => $request->task_description,
                        "android_channel_id" => $identity->app_mobile_name,
                        "sound" => true
                    ]
                ]
            ]);

            $res = json_decode($response->getBody()->getContents());

            if ($res->success == 1) {
                return redirect()->route('task')->with('status', 'success')->with('message', 'Sukses menambah task dan mengirim notifikasi');
            } else {
                return redirect()->route('task')->with('status', 'success')->with('message', 'Sukses menambah task tanpa notifikasi');
            }
        }
    }


    public function update(Request $request, $id)
    {
        $task = Task::where('id', $id)->firstOrFail();

        $task->update([
            'task_title' => $request->task_title ?? $task->task_title,
            'task_description' => $request->task_description ?? $task->task_description,
            'user_id' => $request->user_id ?? $task->user_id,
            'assigned_date' => $request->assigned_date ?? $task->assigned_date,
            'status' => $request->status ?? $task->status,
            'upload_bukti' => $request->upload_bukti ?? $task->upload_bukti,
        ]);

        if ($task) {
            return redirect()->route('task')->with('status', 'success')->with('message', 'Sukses mengedit data');
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Task::find($id);
        if ($data->upload_bukti) {
            Storage::delete('/bukti/' . $data->upload_bukti);
        }
        $data->delete();
        return redirect()->route('task')->with('status', 'success')->with('message', 'Sukses menghapus task');
    }
}
