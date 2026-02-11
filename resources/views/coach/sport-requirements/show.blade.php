@extends('layouts.mastercoach')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Sport Requirement Details</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('coach.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('coach.sport-requirements.index') }}">Sport Requirements</a></li>
                        <li class="breadcrumb-item active">Details</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Sport Requirement Details</h3>
                            <div class="card-tools">
                                <a href="{{ route('coach.sport-requirements.edit', $sportRequirement) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="{{ route('coach.sport-requirements.index') }}" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-arrow-left"></i> Back to List
                                </a>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card card-outline card-success">
                                        <div class="card-header">
                                            <h5 class="card-title">Basic Information</h5>
                                        </div>
                                        <div class="card-body">
                                            <dl class="row">
                                                <dt class="col-sm-5">Sport:</dt>
                                                <dd class="col-sm-7">{{ $sportRequirement->sport_name }}</dd>

                                                <dt class="col-sm-5">Required Gender:</dt>
                                                <dd class="col-sm-7">{{ ucfirst($sportRequirement->required_gender) }}</dd>

                                                <dt class="col-sm-5">Status:</dt>
                                                <dd class="col-sm-7">
                                                    <span class="badge {{ $sportRequirement->is_active ? 'badge-success' : 'badge-danger' }}">
                                                        {{ $sportRequirement->is_active ? 'Active' : 'Inactive' }}
                                                    </span>
                                                </dd>

                                                <dt class="col-sm-5">Created At:</dt>
                                                <dd class="col-sm-7">{{ $sportRequirement->created_at->format('Y-m-d H:i:s') }}</dd>

                                                <dt class="col-sm-5">Updated At:</dt>
                                                <dd class="col-sm-7">{{ $sportRequirement->updated_at->format('Y-m-d H:i:s') }}</dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card card-outline card-primary">
                                        <div class="card-header">
                                            <h5 class="card-title">Requirements</h5>
                                        </div>
                                        <div class="card-body">
                                            <dl class="row">
                                                <dt class="col-sm-5">Age Range:</dt>
                                                <dd class="col-sm-7">
                                                    @if($sportRequirement->min_age && $sportRequirement->max_age)
                                                        {{ $sportRequirement->min_age }}-{{ $sportRequirement->max_age }} years
                                                    @elseif($sportRequirement->min_age)
                                                        {{ $sportRequirement->min_age }}+
                                                    @elseif($sportRequirement->max_age)
                                                        Up to {{ $sportRequirement->max_age }}
                                                    @else
                                                        Any
                                                    @endif
                                                </dd>

                                                <dt class="col-sm-5">Height Range:</dt>
                                                <dd class="col-sm-7">
                                                    @if($sportRequirement->min_height && $sportRequirement->max_height)
                                                        {{ $sportRequirement->min_height }}-{{ $sportRequirement->max_height }} cm
                                                    @elseif($sportRequirement->min_height)
                                                        {{ $sportRequirement->min_height }} cm+
                                                    @elseif($sportRequirement->max_height)
                                                        Up to {{ $sportRequirement->max_height }} cm
                                                    @else
                                                        Any
                                                    @endif
                                                </dd>

                                                <dt class="col-sm-5">Weight Range:</dt>
                                                <dd class="col-sm-7">
                                                    @if($sportRequirement->min_weight && $sportRequirement->max_weight)
                                                        {{ $sportRequirement->min_weight }}-{{ $sportRequirement->max_weight }} kg
                                                    @elseif($sportRequirement->min_weight)
                                                        {{ $sportRequirement->min_weight }} kg+
                                                    @elseif($sportRequirement->max_weight)
                                                        Up to {{ $sportRequirement->max_weight }} kg
                                                    @else
                                                        Any
                                                    @endif
                                                </dd>

                                                <dt class="col-sm-5">Minimum Experience:</dt>
                                                <dd class="col-sm-7">{{ $sportRequirement->min_experience_years ? $sportRequirement->min_experience_years . ' years' : 'None' }}</dd>

                                                <dt class="col-sm-5">Required Level:</dt>
                                                <dd class="col-sm-7">{{ $sportRequirement->required_level ? ucfirst($sportRequirement->required_level) : 'Any' }}</dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card card-outline card-warning">
                                        <div class="card-header">
                                            <h5 class="card-title">Additional Details</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <dt class="font-weight-bold">Required Positions:</dt>
                                                    <dd class="mt-1">
                                                        @if($sportRequirement->required_positions && is_array($sportRequirement->required_positions))
                                                            @foreach($sportRequirement->required_positions as $position)
                                                                <span class="badge badge-secondary mr-1">{{ $position }}</span>
                                                            @endforeach
                                                        @else
                                                            <span class="text-muted">None specified</span>
                                                        @endif
                                                    </dd>
                                                </div>
                                                <div class="col-md-6">
                                                    <dt class="font-weight-bold">Preferred Attributes:</dt>
                                                    <dd class="mt-1">
                                                        @if($sportRequirement->preferred_attributes && is_array($sportRequirement->preferred_attributes))
                                                            @foreach($sportRequirement->preferred_attributes as $attribute)
                                                                <span class="badge badge-info mr-1">{{ $attribute }}</span>
                                                            @endforeach
                                                        @else
                                                            <span class="text-muted">None specified</span>
                                                        @endif
                                                    </dd>
                                                </div>
                                            </div>

                                            <div class="row mt-3">
                                                <div class="col-md-6">
                                                    <dt class="font-weight-bold">Medical Restrictions:</dt>
                                                    <dd class="mt-1">
                                                        @if($sportRequirement->medical_restrictions && is_array($sportRequirement->medical_restrictions))
                                                            @foreach($sportRequirement->medical_restrictions as $restriction)
                                                                <span class="badge badge-danger mr-1">{{ $restriction }}</span>
                                                            @endforeach
                                                        @else
                                                            <span class="text-muted">None specified</span>
                                                        @endif
                                                    </dd>
                                                </div>
                                                <div class="col-md-6">
                                                    <dt class="font-weight-bold">Additional Notes:</dt>
                                                    <dd class="mt-1">{{ $sportRequirement->additional_notes ?: 'None' }}</dd>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <a href="{{ route('coach.sport-requirements.edit', $sportRequirement) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Edit Requirement
                            </a>
                            <a href="{{ route('coach.sport-requirements.index') }}" class="btn btn-secondary ml-2">
                                <i class="fas fa-arrow-left"></i> Back to List
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
