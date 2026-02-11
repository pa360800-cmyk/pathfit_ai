@extends('layouts.masterathlete')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">My Session Schedules</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('athlete.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Session Schedules</li>
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
                            <h3 class="card-title">My Session Schedules</h3>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Coach</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Duration</th>
                                        <th>Status</th>
                                        <th>Notes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($sessionSchedules as $sessionSchedule)
                                        <tr>
                                            <td>{{ $sessionSchedule->id }}</td>
                                            <td>{{ $sessionSchedule->title }}</td>
                                            <td>{{ $sessionSchedule->coach->fname }} {{ $sessionSchedule->coach->lname }}</td>
                                            <td>{{ $sessionSchedule->date }}</td>
                                            <td>{{ $sessionSchedule->start_time }}</td>
                                            <td>{{ $sessionSchedule->duration }} min</td>
                                            <td>{{ ucfirst($sessionSchedule->status) }}</td>
                                            <td>{{ $sessionSchedule->notes }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">No session schedules found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
