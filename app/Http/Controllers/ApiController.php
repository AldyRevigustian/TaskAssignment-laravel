<?php

namespace App\Http\Controllers;

use App\Models\Identity;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ApiController extends Controller
{
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

    public function user_task($user_id)
    {
        $cek = Task::where('user_id', $user_id)
            ->orderBy('created_at', 'DESC')
            ->whereDate('assigned_date', Carbon::today())
            ->get();

        if (count($cek) == 0) {
            return response()->json(['message' => 'Task Not Found'], 404);
        }
        return response()->json($cek);
    }

    public function update_task(Request $request)
    {
        $data = Task::where('id', $request->id)->firstOrFail();

        if ($request->hasFile('upload_bukti')) {
            $request->validate([
                "status" => 'required',
                "upload_bukti" => 'file|max:3072',
                "task_description" => 'required'
            ]);

            $data->update([
                'task_description' =>  $request->task_description,
                'status' => $request->status,
            ]);

            $imageName = 'bukti/' . time() . '.' . $request->upload_bukti->extension();
            Storage::disk('public')->put($imageName, file_get_contents($request->upload_bukti));

            $data->update([
                'upload_bukti' => 'storage/' . $imageName
            ]);

            return response()->json(['success' => true, 'message' => 'Berhasil Mengupdate data'], 200);
        } else {
            return response()->json([
                'succes' => 'false',
                'message' => 'Gagal! Harap Mengisi Image'
            ]);
        }
    }

    public function create_task(Request $request)
    {
        $identity = Identity::first();
        $client = new Client();
        $user = User::where('id', $request->user_id)->first();


        $this->validate($request, [
            "task_title" => 'required',
            "task_description" => 'required',
            "user_id" => 'required',
            "assigned_date" => 'required',
        ]);

        $task = Task::create([
            'task_title' => $request->task_title,
            'task_description' => $request->task_description,
            'user_id' => $request->user_id,
            'assigned_date' => $request->assigned_date,
        ]);

        if ($user->registration == null) {
            if ($task) {
                return response()->json(['success' => true, 'message' => 'Berhasil Menambah Task Tanpa Notifikasi'], 200);
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
                return response()->json(['success' => true, 'message' => 'Berhasil Menambah Task'], 200);
            } else {
                return response()->json(['success' => true, 'message' => 'Berhasil Menambah Task Tanpa Notifikasi'], 200);
            }
        }
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

    public function task()
    {
        $data = Task::orderBy('created_at', 'DESC')->whereDate('assigned_date', Carbon::today())->get();

        $data_fix = [];
        foreach ($data as $d) {
            $data_change['id'] = $d->id;
            $data_change['task_title'] = $d->task_title;
            $data_change['task_description'] = $d->task_description;
            $data_change['assigned_date'] = $d->assigned_date;
            $data_change['status'] = $d->status;
            $data_change['upload_bukti'] = $d->upload_bukti;
            $data_change['assign_to'] = $d->user->name;
            $data_change['updated_at'] = $d->updated_at->format('Y-m-d H:i:s');
            $data_change['created_at'] = $d->created_at->format('Y-m-d H:i:s');
            $data_fix[] = $data_change;
        }

        return response()->json($data_fix);
    }

    public function history_task(Request $request)
    {
        $data = Task::where('status', '!=', 'On Progress')->whereDate('assigned_date', $request->assigned_date)->get();

        $data_fix = [];
        foreach ($data as $d) {
            $data_change['id'] = $d->id;
            $data_change['task_title'] = $d->task_title;
            $data_change['task_description'] = $d->task_description;
            $data_change['assigned_date'] = $d->assigned_date;
            $data_change['status'] = $d->status;
            $data_change['upload_bukti'] = $d->upload_bukti;
            $data_change['user_id'] = $d->user->name;
            $data_change['updated_at'] = $d->updated_at->format('Y-m-d H:i:s');
            $data_change['created_at'] = $d->created_at->format('Y-m-d H:i:s');
            $data_fix[] = $data_change;
        }

        return response()->json($data_fix);
    }

    public function delete_task(Request $request)
    {
        $data = Task::findOrFail($request->id);

        if ($data->upload_bukti) {
            Storage::delete('/bukti/' . $data->upload_bukti);
        }

        $data->delete();

        return response()->json(['success' => true, 'Message' => 'Berhasil Delete Task']);
    }
}
