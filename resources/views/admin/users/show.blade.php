@extends('layouts.master')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">User Details</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users Management</a></li>
                        <li class="breadcrumb-item active">Details</li>
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
                            <h3 class="card-title">User Details</h3>
                            <div class="card-tools">
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning btn-sm">Edit</a>
                                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">Back to List</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <dl class="row">
                                <dt class="col-sm-3">ID</dt>
                                <dd class="col-sm-9">{{ $user->id }}</dd>

                                <dt class="col-sm-3">Name</dt>
                                <dd class="col-sm-9">{{ $user->name }}</dd>

                                <dt class="col-sm-3">Email</dt>
                                <dd class="col-sm-9">{{ $user->email }}</dd>

                                <dt class="col-sm-3">Role</dt>
                                <dd class="col-sm-9">
                                    <span class="badge badge-{{ $user->role == 'Administrator' ? 'primary' : ($user->role == 'Coach' ? 'success' : 'info') }}">
                                        {{ $user->role }}
                                    </span>
                                </dd>

                                @if($user->role == 'Coach')
                                <dt class="col-sm-3">Specialization</dt>
                                <dd class="col-sm-9">{{ $user->specialization ?? 'General Training' }}</dd>

                                <dt class="col-sm-3">Experience</dt>
                                <dd class="col-sm-9">{{ $user->experience ?? 'N/A' }} years</dd>
                                @endif

                                <dt class="col-sm-3">Status</dt>
                                <dd class="col-sm-9">
                                    <span class="badge badge-success">Active</span>
                                </dd>

                                <dt class="col-sm-3">Created At</dt>
                                <dd class="col-sm-9">{{ $user->created_at->format('Y-m-d H:i:s') }}</dd>

                                <dt class="col-sm-3">Updated At</dt>
                                <dd class="col-sm-9">{{ $user->updated_at->format('Y-m-d H:i:s') }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
