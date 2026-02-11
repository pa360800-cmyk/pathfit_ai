@extends('layouts.mastercoach')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Coach Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <!-- Welcome Row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Welcome, {{ auth()->user()->name }}!</h3>
                        </div>
                        <div class="card-body">
                            <p>This is your coach dashboard. Here you can manage athletes, view training data, and more.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Row -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $athletesCount ?? 0 }}</h3>
                            <p>Assigned Athletes</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <a href="{{ route('coach.athletes.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $upcomingSessions ?? 0 }}</h3>
                            <p>Upcoming Sessions</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <a href="{{ route('coach.training-schedules.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $recentActivities ?? 0 }}</h3>
                            <p>Recent Activities</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <a href="{{ route('coach.activity-reports.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $messagesCount ?? 0 }}</h3>
                            <p>Unread Messages</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <a href="{{ route('coach.messages.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>

            <!-- Content Row -->
            <div class="row">
                <!-- Upcoming Training Sessions -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Upcoming Training Sessions</h3>
                        </div>
                        <div class="card-body">
                            @if(isset($upcomingSessionsList) && $upcomingSessionsList->count() > 0)
                                <ul class="list-group list-group-flush">
                                    @foreach($upcomingSessionsList->take(5) as $session)
                                        <li class="list-group-item">
                                            <strong>{{ $session->title }}</strong> - {{ $session->scheduled_date ? $session->scheduled_date->format('M d, Y') : 'Date not set' }} at {{ $session->scheduled_time ?? 'Time not set' }}
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p>No upcoming sessions scheduled.</p>
                            @endif
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('coach.training-schedules.index') }}" class="btn btn-primary btn-sm">View All Sessions</a>
                        </div>
                    </div>
                </div>

                <!-- Recent Athlete Activities -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Recent Athlete Activities</h3>
                        </div>
                        <div class="card-body">
                            @if(isset($recentActivitiesList) && $recentActivitiesList->count() > 0)
                                <ul class="list-group list-group-flush">
                                    @foreach($recentActivitiesList->take(5) as $activity)
                                        <li class="list-group-item">
                                            <strong>{{ $activity->user->name }}</strong> completed {{ $activity->activity_name }} on {{ $activity->date ? $activity->date->format('M d, Y') : 'Date not set' }}
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p>No recent activities reported.</p>
                            @endif
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('coach.activity-reports.index') }}" class="btn btn-primary btn-sm">View All Activities</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions Row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Quick Actions</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <a href="{{ route('coach.athletes.index') }}" class="btn btn-app">
                                        <i class="fas fa-users"></i> Manage Athletes
                                    </a>
                                </div>
                                <div class="col-md-3">
                                    <a href="{{ route('coach.training-schedules.create') }}" class="btn btn-app">
                                        <i class="fas fa-calendar-plus"></i> Create Session
                                    </a>
                                </div>
                                <div class="col-md-3">
                                    <a href="{{ route('coach.sport-requirements.index') }}" class="btn btn-app">
                                        <i class="fas fa-list"></i> Sport Requirements
                                    </a>
                                </div>
                                <div class="col-md-3">
                                    <a href="{{ route('coach.messages.index') }}" class="btn btn-app">
                                        <i class="fas fa-envelope"></i> Messages
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
