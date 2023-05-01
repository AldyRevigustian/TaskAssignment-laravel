@extends('layouts.master')


@section('content')
    <style>
        input:read-only {
            background-color: white;
            pointer-events: all
        } ;
    </style>
    @include('message')

    <form action="{{ route('identity.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-center">
                    <img src="{{ $identity->app_logo }}" alt=""
                        style="width: 200px;height: 200px;object-fit: contain; margin-bottom: 24px">
                </div>
                <table class="table">
                    <tr>
                        <th class="col-3">App Logo</th>
                        <td>
                            <input type="file" accept="image/*" name="app_logo" class="form-control">
                        </td>
                    </tr>
                    <tr>
                        <th class="col-3">App Name</th>
                        <td>
                            <input class="form-control" type="text" name="app_name" value="{{ $identity->app_name }}">
                        </td>
                    </tr>
                    <tr>
                        <th class="col-3">Company Name</th>
                        <td>
                            <input class="form-control" type="text" name="company_name" value="{{ $identity->company_name }}">
                        </td>
                    </tr>
                    <tr>
                        <th class="col-3">App Authorization (Firebase Cloud Message)</th>
                        <td>
                            <textarea name="app_authorization" class="form-control" rows="8">{{ $identity->app_authorization }}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <th class="col-3">App Mobile Package Name</th>
                        <td>
                            <input class="form-control" type="text" name="app_mobile_name" value="{{ $identity->app_mobile_name }}">
                        </td>
                    </tr>
                </table>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary">
                    Save
                </button>
            </div>
        </div>
    </form>
@endsection
