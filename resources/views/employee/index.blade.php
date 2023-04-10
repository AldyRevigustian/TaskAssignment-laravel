@extends('layouts.master')


@section('content')
    <style>
        input:read-only {
            background-color: white;
            pointer-events: initial;
        }
    </style>

    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last mb-1">
                    <h3>Employee</h3>
                </div>
            </div>
            @include('message')
        </div>
        <section class="section mt-3">
            <div class="card shadow-sm">
                <div class="card-header" style="padding-bottom: 0px">
                    <h5>
                        List Employee
                    </h5>
                    <hr>
                </div>
                <div class="card-body">
                    <a href="#" class="btn icon btn-primary text-light" data-bs-toggle="modal" data-bs-target="#add"><i
                            class="bi bi-plus-lg"></i>Add</a>
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th class="col-1">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employees as $key => $employee)
                                <tr>
                                    <td class="col-1">{{ $key + 1 }}</td>
                                    <td class="col-1">
                                        <div class="avatar avatar-lg">
                                            <img src="{{ $employee->photo }}" />
                                        </div>
                                    </td>
                                    <td>{{ ucfirst($employee->name) }}</td>
                                    <td>{{ $employee->email }}</td>
                                    <td>
                                        <a href="#" class="btn icon btn-warning text-light" data-bs-toggle="modal"
                                            data-bs-target="#edit{{ $employee->id }}"><i class="bi bi-pencil-fill"></i></a>
                                        <form class="d-inline" method="POST"
                                            action="{{ route('employee.delete', $employee->id) }}">
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
                    <h4 class="modal-title" id="myModalLabel33">Tambah Employee</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('employee.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <label>Name : </label>
                        <div class="form-group">
                            <input type="text" placeholder="Name" class="form-control" name="name" required>
                        </div>

                        <label>Email : </label>
                        <div class="form-group">
                            <input type="email" placeholder="Email" class="form-control" name="email" required>
                        </div>

                        <label>Photo : </label>
                        <div class="form-group">
                            <input type="file" accept="image/*" placeholder="Title" class="form-control" name="photo"
                                required>
                        </div>

                        <label>Password : </label>
                        <div class="form-group">
                            <input type="password" placeholder="Password" class="form-control" name="password" required>
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

    @foreach ($employees as $employee)
        <div class="modal fade text-left" id="edit{{ $employee->id }}" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33">Edit Employee</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('employee.update', $employee->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <label>Name : </label>
                            <div class="form-group">
                                <input type="text" placeholder="Name" class="form-control" name="name" required
                                    value="{{ $employee->name }}">
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
    @endforeach
@endsection
