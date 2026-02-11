@extends('layouts.master')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Sport Available Details</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.sport-available.index') }}">Sport Available</a></li>
                        <li class="breadcrumb-item active">Show</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Sport Available Details</h3>
                            <div class="card-tools">
                                <a href="{{ route('admin.sport-available.edit', $sportAvailable) }}" class="btn btn-primary btn-sm">Edit</a>
                                <a href="{{ route('admin.sport-available.index') }}" class="btn btn-secondary btn-sm">Back</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th>ID</th>
                                    <td>{{ $sportAvailable->id }}</td>
                                </tr>
                                <tr>
                                    <th>Name</th>
                                    <td>{{ $sportAvailable->name }}</td>
                                </tr>
                                <tr>
                                    <th>Description</th>
                                    <td>{{ $sportAvailable->description }}</td>
                                </tr>
                                <tr>
                                    <th>Created At</th>
                                    <td>{{ $sportAvailable->created_at }}</td>
                                </tr>
                                <tr>
                                    <th>Updated At</th>
                                    <td>{{ $sportAvailable->updated_at }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
