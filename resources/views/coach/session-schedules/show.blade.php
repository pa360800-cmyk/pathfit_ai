@extends('layouts.mastercoach')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Session Schedule Details</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('coach.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('coach.session-schedules.index') }}">Session Schedules</a></li>
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
                            <h3 class="card-title">Session Schedule Details</h3>
                            <div class="card-tools">
                                <a href="{{ route('coach.session-schedules.edit', $sessionSchedule) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="{{ route('coach.session-schedules.index') }}" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-arrow-left"></i> Back to List
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <dl class="row">
                                <dt class="col-sm-3">ID</dt>
                                <dd class="col-sm-9">{{ $sessionSchedule->id }}</dd>

                                <dt class="col-sm-3">Title</dt>
                                <dd class="col-sm-9">{{ $sessionSchedule->title }}</dd>

                                <dt class="col-sm-3">Description</dt>
                                <dd class="col-sm-9">{{ $sessionSchedule->description ?: 'No description provided.' }}</dd>

                                <dt class="col-sm-3">Date</dt>
                                <dd class="col-sm-9">{{ $sessionSchedule->date }}</dd>

                                <dt class="col-sm-3">Start Time</dt>
                                <dd class="col-sm-9">{{ $sessionSchedule->start_time }}</dd>

                                <dt class="col-sm-3">End Time</dt>
                                <dd class="col-sm-9">{{ $sessionSchedule->end_time }}</dd>

                                <dt class="col-sm-3">Coach</dt>
                                <dd class="col-sm-9">{{ $sessionSchedule->coach->name }}</dd>

                                <dt class="col-sm-3">Created At</dt>
                                <dd class="col-sm-9">{{ $sessionSchedule->created_at }}</dd>

                                <dt class="col-sm-3">Updated At</dt>
                                <dd class="col-sm-9">{{ $sessionSchedule->updated_at }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
