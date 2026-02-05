@extends('layouts.master')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-user-circle mr-2 text-primary"></i>My Profile
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i> Home</a></li>
                        <li class="breadcrumb-item active"><i class="fas fa-user"></i> My Profile</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header bg-gradient-primary">
                            <h3 class="card-title">
                                <i class="fas fa-id-card mr-2"></i>Profile Information
                            </h3>
                            <div class="card-tools">
                                <a href="{{ route('admin.profile.edits') }}" class="btn btn-light btn-sm">
                                    <i class="fas fa-edit mr-1"></i>Edit Profile
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <i class="icon fas fa-check-circle mr-2"></i>{{ session('success') }}
                                </div>
                            @endif

                            @if(session('error'))
                                <div class="alert alert-danger alert-dismissible fade show">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <i class="icon fas fa-exclamation-triangle mr-2"></i>{{ session('error') }}
                                </div>
                            @endif

                            <!-- Profile Image Section -->
                            <div class="row mb-4">
                                <div class="col-md-12 text-center">
                                    <div class="profile-image-container position-relative d-inline-block">
                                        @if($user->photo)
                                            <img src="{{ asset('storage/' . $user->photo) }}" alt="Profile Image" class="img-circle elevation-3 shadow-lg" style="width: 180px; height: 180px; object-fit: cover; border: 6px solid #fff; box-shadow: 0 8px 25px rgba(0,123,255,0.3);">
                                        @else
                                            <img src="{{ asset('adminlte/dist/img/avatar5.png') }}" alt="Default Profile Image" class="img-circle elevation-3 shadow-lg" style="width: 180px; height: 180px; object-fit: cover; border: 6px solid #fff; box-shadow: 0 8px 25px rgba(108,117,125,0.3);">
                                        @endif
                                        <div class="position-absolute" style="bottom: 10px; right: 10px;">
                                            <span class="badge badge-{{ $user->role == 'Administrator' ? 'primary' : ($user->role == 'Coach' ? 'success' : 'info') }} badge-pill p-2">
                                                <i class="fas fa-{{ $user->role == 'Administrator' ? 'crown' : ($user->role == 'Coach' ? 'chalkboard-teacher' : 'running') }} mr-1"></i>{{ $user->role }}
                                            </span>
                                        </div>
                                    </div>
 
                                </div>
                            </div>

                            <!-- Basic Information -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <p class="form-control-plaintext">{{ $user->name }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <p class="form-control-plaintext">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="role">Role</label>
                                        <p class="form-control-plaintext">
                                            <span class="badge badge-{{ $user->role == 'Administrator' ? 'primary' : ($user->role == 'Coach' ? 'success' : 'info') }}">
                                                {{ $user->role }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="created_at">Member Since</label>
                                        <p class="form-control-plaintext">{{ $user->created_at->format('M d, Y') }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Additional Details -->
                            @if($user->role == 'Athlete')
                                <hr>
                                <h5 class="text-primary">Athlete Details</h5>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="age">Age</label>
                                            <p class="form-control-plaintext">{{ $user->age ?? 'Not specified' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="gender">Gender</label>
                                            <p class="form-control-plaintext">{{ $user->gender ?? 'Not specified' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="date_of_birth">Date of Birth</label>
                                            <p class="form-control-plaintext">{{ $user->date_of_birth ? $user->date_of_birth->format('M d, Y') : 'Not specified' }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="height">Height (cm)</label>
                                            <p class="form-control-plaintext">{{ $user->height ?? 'Not specified' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="weight">Weight (kg)</label>
                                            <p class="form-control-plaintext">{{ $user->weight ?? 'Not specified' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="primary_sport">Primary Sport</label>
                                            <p class="form-control-plaintext">{{ $user->primary_sport ?? 'Not specified' }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="position_role">Position/Role</label>
                                            <p class="form-control-plaintext">{{ $user->position_role ?? 'Not specified' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="level">Level</label>
                                            <p class="form-control-plaintext">{{ $user->level ?? 'Not specified' }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="years_active">Years Active</label>
                                            <p class="form-control-plaintext">{{ $user->years_active ?? 'Not specified' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="weekly_training_hours">Weekly Training Hours</label>
                                            <p class="form-control-plaintext">{{ $user->weekly_training_hours ?? 'Not specified' }}</p>
                                        </div>
                                    </div>
                                </div>
                            @elseif($user->role == 'Coach')
                                <hr>
                                <h5 class="text-success">Coach Details</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="specialization">Specialization</label>
                                            <p class="form-control-plaintext">{{ $user->specialization ?? 'Not specified' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="experience_years">Experience (Years)</label>
                                            <p class="form-control-plaintext">{{ $user->experience_years ?? 'Not specified' }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
