@extends ('layouts.master')

@section('content')
    <h3 class="mb-3">Profile Statistics</h3>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
                <div class="row">
                    <div class="col-6 col-lg-6 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-2 d-flex justify-content-start">
                                        <div class="stats-icon red mb-2">
                                            <i class="iconly-boldProfile"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Employee</h6>
                                        <h6 class="font-extrabold mb-0">
                                            {{ \App\Models\User::where('role', 'user')->count() }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-lg-6 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md- col-lg-12 col-xl-12 col-xxl-2 d-flex justify-content-start">
                                        <div class="stats-icon blue mb-2">
                                            <i class="iconly-boldBookmark"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-10">
                                        <h6 class="text-muted font-semibold">Today Task</h6>
                                        <h6 class="font-extrabold mb-0">{{ \App\Models\Task::count() }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Latest Task</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Assign To</th>
                                        <th>Task</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tasks->slice(0,5) as $task)
                                        <tr>
                                            <td class="col-2 pb-3 pt-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-md">
                                                        <img src="{{ $task->user->photo }}" />
                                                    </div>
                                                    <p class="font-bold ms-3 mb-0">{{ ucfirst($task->user->name) }}</p>
                                                </div>
                                            </td>
                                            <td class="col-auto">
                                                <p class="mb-0">
                                                    {{ $task->task_title }}
                                                </p>
                                            </td>
                                            <td class="col-auto">
                                                <p class="mb-0">
                                                    {{ $task->task_description }}
                                                </p>
                                            </td>
                                            <td class="col-2">
                                                <p class="mb-0">
                                                    {{ $task->status }}
                                                </p>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
