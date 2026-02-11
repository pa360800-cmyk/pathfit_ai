@extends('layouts.mastercoach')

@section('title', 'View Event')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $event->title }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('coach.events.edit', $event) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('coach.events.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Events
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-3">Title:</dt>
                        <dd class="col-sm-9">{{ $event->title }}</dd>

                        <dt class="col-sm-3">Description:</dt>
                        <dd class="col-sm-9">{{ $event->description ?? 'No description provided.' }}</dd>

                        <dt class="col-sm-3">Event Date & Time:</dt>
                        <dd class="col-sm-9">{{ $event->event_date->format('Y-m-d H:i') }}</dd>

                        <dt class="col-sm-3">Location:</dt>
                        <dd class="col-sm-9">{{ $event->location ?? 'No location specified.' }}</dd>

                        <dt class="col-sm-3">Created By:</dt>
                        <dd class="col-sm-9">{{ $event->creator->name ?? 'Unknown' }}</dd>

                        <dt class="col-sm-3">Created At:</dt>
                        <dd class="col-sm-9">{{ $event->created_at->format('Y-m-d H:i') }}</dd>

                        <dt class="col-sm-3">Updated At:</dt>
                        <dd class="col-sm-9">{{ $event->updated_at->format('Y-m-d H:i') }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
