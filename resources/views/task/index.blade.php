@extends('layouts.master')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last mb-1">
                    <h3>Task</h3>
                </div>
            </div>
            @include('message')
        </div>
        <section class="section mt-3">
            <div class="card shadow-sm">
                <div class="card-header" style="padding-bottom: 0px">
                    <h5>
                        List Task
                    </h5>
                    <hr>
                </div>
                <div class="card-body">
                    <a href="#" class="btn icon btn-primary text-light" data-bs-toggle="modal" data-bs-target="#add"><i
                            class="bi bi-plus-lg"></i> Add</a>
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th class="col-1">No.</th>
                                <th> AssignTo </th>
                                <th> Task Title </th>
                                <th> Description </th>
                                <th> Bukti </th>
                                <th> Tanggal </th>
                                <th> Status </th>
                                <th class="col-1">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tasks as $key => $task)
                                <tr>
                                    <td class="col-1">{{ $key + 1 }}</td>
                                    <td>{{ ucfirst($task->user->name) }}</td>
                                    <td>{{ $task->task_title }}</td>
                                    <td>{{ $task->task_description }}</td>
                                    <td class="col-1">{{ $task->upload_bukti }}</td>
                                    <td class="col-1">{{ $task->tanggal }}</td>
                                    <td class="col-1">{{ $task->status }}</td>
                                    <td class="col-1">
                                        <a href="#" class="btn icon btn-warning text-light" data-bs-toggle="modal"
                                            data-bs-target="#edit{{ $task->id }}"><i class="bi bi-pencil-fill"></i></a>
                                        <form class="d-inline" method="POST"
                                            action="{{ route('task.delete', $task->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn icon btn-danger"><i
                                                    class="bi bi-trash-fill"></i></a>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>

    <div class="modal fade text-left" id="add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Tambah Task</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('task.store') }}" method="POST">
                        @csrf
                        <label>Task Title: </label>
                        <div class="form-group">
                            <input type="text" placeholder="Task title" class="form-control" name="task_title" required>
                        </div>

                        <label>Task Description: </label>
                        <div class="form-group">
                            <input type="text" placeholder="Task Description" class="form-control"
                                name="task_description" required>
                        </div>

                        <label>Assign To: </label>
                        <div class="form-group">
                            <select name="user_id" class="form-select">
                                <option value="" disabled selected>
                                    --Assign To--</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <label>Tanggal: </label>
                        <div class="form-group">
                            <input type="date" placeholder="Task Description" class="form-control" name="tanggal"
                                required value="{{ date('Y-m-d') }}" readonly>
                        </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button type="submit" class="btn btn-primary ml-1">
                        <span class="d-none d-sm-block">Add</span>
                    </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- @foreach ($tasks as $task)
        <div class="modal fade text-left" id="edit{{ $task->id }}" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33">Edit Task</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('task.update', $task->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <label>Name : </label>
                            <div class="form-group">
                                <input type="text" placeholder="Name" class="form-control" name="name" required
                                    value="{{ $task->name }}">
                            </div>

                            <label>Photo : </label>
                            <div class="form-group">
                                <input type="file" accept="image/*" placeholder="Title" class="form-control"
                                    name="photo">
                            </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Close</span>
                        </button>
                        <button type="submit" class="btn btn-primary ml-1">
                            <span class="d-none d-sm-block">Update</span>
                        </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach --}}
@endsection
