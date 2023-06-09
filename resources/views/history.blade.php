@extends('layouts.master')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last mb-1">
                    <h3>Task History</h3>
                </div>
            </div>
            @include('message')
        </div>
        <section class="section mt-3">
            <div class="card shadow-sm">
                <div class="card-header" style="padding-bottom: 0px">
                    <h5>
                        Task History
                    </h5>
                    <hr>
                </div>
                <div class="card-body">
                    <form action="{{ route('history') }}" class="d-flex col-8 gap-2">
                        <div class="col-4">
                            <div class="input-group">
                                <input type="date" class="form-control" placeholder="DD-MM-YYYY" name="filter"
                                    value="{{ $date }}" required>
                            </div>
                        </div>
                        <div class="col-8">
                            <button class="btn btn-primary" type="submit">Filter</button>
                        </div>
                    </form>
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th class="col-1">No.</th>
                                <th>AssignTo</th>
                                <th>Task Title</th>
                                <th>Description</th>
                                <th>Bukti</th>
                                <th>Status</th>
                                <th class="text-center">Assigned Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tasks as $key => $task)
                                <tr>
                                    <td class="col-1">{{ $key + 1 }}</td>
                                    <td class="col-1">{{ ucfirst($task->user->name) }}</td>
                                    <td style="max-width: 100px">{{ $task->task_title }}</td>
                                    <td style="max-width: 300px">{{ $task->task_description }}</td>
                                    <td class="col-1">
                                        @if ($task->upload_bukti)
                                            <div class="avatar avatar-lg">
                                                <img src="{{ $task->upload_bukti }}" />
                                            </div>
                                        @endif
                                    </td>
                                    <td class="col-1">
                                        @if ($task->status == 'Complete')
                                            <span class="badge bg-success col-12">{{ $task->status }}</span>
                                        @elseif ($task->status == 'Incomplete')
                                            <span class="badge bg-danger col-12">{{ $task->status }}</span>
                                        @else
                                            <span class="badge bg-secondary col-12">{{ $task->status }}</span>
                                        @endif
                                    </td>
                                    <td class="col-1 text-center">{{ date('Y-m-d H:i', strtotime($task->assigned_date)) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
@endsection
