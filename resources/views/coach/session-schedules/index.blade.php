@extends('layouts.mastercoach')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Session Schedules</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('coach.dashboard') }}">Dashboard</a></li>
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
                            <h3 class="card-title">Session Schedules</h3>
                            <div class="card-tools">
                                <a href="{{ route('coach.session-schedules.create') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus"></i> Add Session Schedule
                                </a>
                            </div>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Athlete</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Duration</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($sessionSchedules as $sessionSchedule)
                                        <tr>
                                            <td>{{ $sessionSchedule->id }}</td>
                                            <td>{{ $sessionSchedule->athlete->fname }} {{ $sessionSchedule->athlete->lname }}</td>
                                            <td>{{ $sessionSchedule->date }}</td>
                                            <td>{{ $sessionSchedule->start_time }}</td>
                                            <td>{{ $sessionSchedule->duration }} min</td>
                                            <td>{{ ucfirst($sessionSchedule->status) }}</td>
                                            <td>
                                                <a href="{{ route('coach.session-schedules.show', $sessionSchedule) }}" class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                                <a href="{{ route('coach.session-schedules.edit', $sessionSchedule) }}" class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <form action="{{ route('coach.session-schedules.destroy', $sessionSchedule) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this session schedule?')">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">No session schedules found.</td>
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
