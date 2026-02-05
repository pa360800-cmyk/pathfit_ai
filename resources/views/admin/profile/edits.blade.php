@extends('layouts.master')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-user-edit mr-2"></i>Edit Profile
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.profile.index') }}">Profile</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8">
                    <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-user mr-2"></i>Profile Information
                                </h3>
                            </div>
                            <div class="card-body">
                                @if(session('status'))
                                    <div class="alert alert-success alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <i class="icon fas fa-check"></i> {{ session('status') }}
                                    </div>
                                @endif

                                <!-- Profile Image Section -->
                                <div class="row mb-4">
                                    <div class="col-md-12 text-center">
                                        <div class="profile-image-container mb-3">
                                            @if($user->photo)
                                                <img id="profile-image-preview" src="{{ asset('storage/' . $user->photo) }}" alt="Profile Image" class="img-circle elevation-2" style="width: 120px; height: 120px; object-fit: cover; border: 4px solid #007bff; cursor: pointer;" onclick="document.getElementById('photo').click();">
                                            @else
                                                <img id="profile-image-preview" src="{{ asset('adminlte/dist/img/avatar5.png') }}" alt="Default Profile Image" class="img-circle elevation-2" style="width: 120px; height: 120px; object-fit: cover; border: 4px solid #007bff; cursor: pointer;" onclick="document.getElementById('photo').click();">
                                            @endif
                                            <div class="mt-2">
                                                <small class="text-muted">Click the image to change photo</small>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="photo">
                                                <i class="fas fa-camera mr-1"></i>Profile Photo
                                            </label>
                                            <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo" accept="image/*" onchange="previewImage(event)">
                                            <small class="form-text text-muted">Upload a new profile photo (JPG, PNG, max 2MB)</small>
                                            @error('photo')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Basic Information -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">
                                                <i class="fas fa-signature mr-1"></i>Name
                                            </label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required placeholder="Enter your full name">
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">
                                                <i class="fas fa-envelope mr-1"></i>Email Address
                                            </label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required placeholder="Enter your email">
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="role">
                                                <i class="fas fa-user-tag mr-1"></i>Role
                                            </label>
                                            <input type="text" class="form-control" id="role" value="{{ $user->role }}" readonly>
                                            <small class="form-text text-muted">Role cannot be changed from here</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="created_at">
                                                <i class="fas fa-calendar-alt mr-1"></i>Member Since
                                            </label>
                                            <input type="text" class="form-control" id="created_at" value="{{ $user->created_at->format('M d, Y') }}" readonly>
                                        </div>
                                    </div>
                                </div>

                                <!-- Change Password Section -->
                                <hr>
                                <h5 class="text-info mb-3">
                                    <i class="fas fa-lock mr-2"></i>Change Password
                                </h5>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="current_password">
                                                <i class="fas fa-key mr-1"></i>Current Password
                                            </label>
                                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password" placeholder="Enter current password">
                                            @error('current_password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="password">
                                                <i class="fas fa-lock mr-1"></i>New Password
                                            </label>
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Enter new password">
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="password_confirmation">
                                                <i class="fas fa-lock mr-1"></i>Confirm New Password
                                            </label>
                                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" placeholder="Confirm new password">
                                            @error('password_confirmation')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <small class="form-text text-muted">Leave password fields blank if you don't want to change your password.</small>

                                <!-- Role-specific Additional Fields -->
                                @if($user->role == 'Athlete')
                                    <hr>
                                    <h5 class="text-primary mb-3">
                                        <i class="fas fa-running mr-2"></i>Athlete Details
                                    </h5>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="age">
                                                    <i class="fas fa-birthday-cake mr-1"></i>Age
                                                </label>
                                                <input type="number" class="form-control @error('age') is-invalid @enderror" id="age" name="age" value="{{ old('age', $user->age) }}" min="1" max="120" placeholder="Enter your age">
                                                @error('age')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="gender">
                                                    <i class="fas fa-venus-mars mr-1"></i>Gender
                                                </label>
                                                <select class="form-control @error('gender') is-invalid @enderror" id="gender" name="gender">
                                                    <option value="">Select Gender</option>
                                                    <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                                    <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                                    <option value="other" {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>Other</option>
                                                </select>
                                                @error('gender')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="date_of_birth">
                                                    <i class="fas fa-calendar-day mr-1"></i>Date of Birth
                                                </label>
                                                <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $user->date_of_birth ? $user->date_of_birth->format('Y-m-d') : '') }}">
                                                @error('date_of_birth')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="height">
                                                    <i class="fas fa-ruler-vertical mr-1"></i>Height (cm)
                                                </label>
                                                <input type="number" class="form-control @error('height') is-invalid @enderror" id="height" name="height" value="{{ old('height', $user->height) }}" min="50" max="250" step="0.1" placeholder="Enter height in cm">
                                                @error('height')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="weight">
                                                    <i class="fas fa-weight mr-1"></i>Weight (kg)
                                                </label>
                                                <input type="number" class="form-control @error('weight') is-invalid @enderror" id="weight" name="weight" value="{{ old('weight', $user->weight) }}" min="20" max="300" step="0.1" placeholder="Enter weight in kg">
                                                @error('weight')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="primary_sport">
                                                    <i class="fas fa-trophy mr-1"></i>Primary Sport
                                                </label>
                                                <input type="text" class="form-control @error('primary_sport') is-invalid @enderror" id="primary_sport" name="primary_sport" value="{{ old('primary_sport', $user->primary_sport) }}" placeholder="e.g., Basketball, Football">
                                                @error('primary_sport')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="position_role">
                                                    <i class="fas fa-user-friends mr-1"></i>Position/Role
                                                </label>
                                                <input type="text" class="form-control @error('position_role') is-invalid @enderror" id="position_role" name="position_role" value="{{ old('position_role', $user->position_role) }}" placeholder="e.g., Forward, Goalkeeper">
                                                @error('position_role')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="level">
                                                    <i class="fas fa-chart-line mr-1"></i>Level
                                                </label>
                                                <select class="form-control @error('level') is-invalid @enderror" id="level" name="level">
                                                    <option value="">Select Level</option>
                                                    <option value="beginner" {{ old('level', $user->level) == 'beginner' ? 'selected' : '' }}>Beginner</option>
                                                    <option value="intermediate" {{ old('level', $user->level) == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                                    <option value="advanced" {{ old('level', $user->level) == 'advanced' ? 'selected' : '' }}>Advanced</option>
                                                    <option value="professional" {{ old('level', $user->level) == 'professional' ? 'selected' : '' }}>Professional</option>
                                                </select>
                                                @error('level')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="years_active">
                                                    <i class="fas fa-clock mr-1"></i>Years Active
                                                </label>
                                                <input type="number" class="form-control @error('years_active') is-invalid @enderror" id="years_active" name="years_active" value="{{ old('years_active', $user->years_active) }}" min="0" max="50" placeholder="Years of experience">
                                                @error('years_active')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="weekly_training_hours">
                                                    <i class="fas fa-calendar-week mr-1"></i>Weekly Training Hours
                                                </label>
                                                <input type="number" class="form-control @error('weekly_training_hours') is-invalid @enderror" id="weekly_training_hours" name="weekly_training_hours" value="{{ old('weekly_training_hours', $user->weekly_training_hours) }}" min="0" max="168" step="0.5" placeholder="Hours per week">
                                                @error('weekly_training_hours')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                @elseif($user->role == 'Coach')
                                    <hr>
                                    <h5 class="text-success mb-3">
                                        <i class="fas fa-chalkboard-teacher mr-2"></i>Coach Details
                                    </h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="specialization">
                                                    <i class="fas fa-graduation-cap mr-1"></i>Specialization
                                                </label>
                                                <input type="text" class="form-control @error('specialization') is-invalid @enderror" id="specialization" name="specialization" value="{{ old('specialization', $user->specialization) }}" placeholder="e.g., Basketball, Football">
                                                @error('specialization')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="experience_years">
                                                    <i class="fas fa-award mr-1"></i>Experience (Years)
                                                </label>
                                                <input type="number" class="form-control @error('experience_years') is-invalid @enderror" id="experience_years" name="experience_years" value="{{ old('experience_years', $user->experience_years) }}" min="0" max="50" placeholder="Years of coaching experience">
                                                @error('experience_years')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save mr-1"></i>Update Profile
                                </button>
                                <a href="{{ route('admin.profile.index') }}" class="btn btn-secondary ml-2">
                                    <i class="fas fa-times mr-1"></i>Cancel
                                </a>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-lg-4">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-info-circle mr-2"></i>Help & Tips
                            </h3>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check text-success mr-2"></i>Keep your name and email up to date</li>
                                <li><i class="fas fa-check text-success mr-2"></i>Use a valid email address</li>
                                <li><i class="fas fa-check text-success mr-2"></i>Your role is assigned by administrators</li>
                                <li><i class="fas fa-check text-success mr-2"></i>Changes will be reflected immediately</li>
                            </ul>
                        </div>
                    </div>

                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-exclamation-triangle mr-2"></i>Important Notes
                            </h3>
                        </div>
                        <div class="card-body">
                            <p class="text-muted">
                                <i class="fas fa-info-circle mr-1"></i>
                                If you change your email, you'll need to verify it again.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
