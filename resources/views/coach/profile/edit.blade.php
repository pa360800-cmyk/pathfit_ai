@extends('layouts.mastercoach')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-user-edit mr-2"></i>Edit Coach Profile
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('coach.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('coach.profile.index') }}">My Profile</a></li>
                        <li class="breadcrumb-item active">Edit Profile</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <form method="POST" action="{{ route('coach.profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-user mr-2"></i>Basic Information
                                </h3>
                            </div>
                            <div class="card-body">
                                @if(session('status'))
                                    <div class="alert alert-success alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <i class="icon fas fa-check"></i> {{ session('status') }}
                                    </div>
                                @endif

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="fname">
                                                <i class="fas fa-signature mr-1"></i>First Name
                                            </label>
                                            <input type="text" class="form-control @error('fname') is-invalid @enderror" id="fname" name="fname" value="{{ old('fname', $user->fname) }}" required placeholder="Enter your first name">
                                            @error('fname')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="mname">
                                                <i class="fas fa-signature mr-1"></i>Middle Name
                                            </label>
                                            <input type="text" class="form-control @error('mname') is-invalid @enderror" id="mname" name="mname" value="{{ old('mname', $user->mname) }}" placeholder="Enter your middle name">
                                            @error('mname')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="lname">
                                                <i class="fas fa-signature mr-1"></i>Last Name
                                            </label>
                                            <input type="text" class="form-control @error('lname') is-invalid @enderror" id="lname" name="lname" value="{{ old('lname', $user->lname) }}" required placeholder="Enter your last name">
                                            @error('lname')
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
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="gender">
                                                <i class="fas fa-venus-mars mr-1"></i>Gender
                                            </label>
                                            <select class="form-control @error('gender') is-invalid @enderror" id="gender" name="gender">
                                                <option value="">Select Gender</option>
                                                <option value="Male" {{ old('gender', $user->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                                <option value="Female" {{ old('gender', $user->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                                                <option value="Other" {{ old('gender', $user->gender) == 'Other' ? 'selected' : '' }}>Other</option>
                                            </select>
                                            @error('gender')
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
                                            <label for="date_of_birth">
                                                <i class="fas fa-birthday-cake mr-1"></i>Date of Birth
                                            </label>
                                            <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $user->date_of_birth ? $user->date_of_birth->format('Y-m-d') : '') }}">
                                            @error('date_of_birth')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="age">
                                                <i class="fas fa-birthday-cake mr-1"></i>Age
                                            </label>
                                            <input type="number" class="form-control @error('age') is-invalid @enderror" id="age" name="age" value="{{ old('age', $user->age) }}" placeholder="Enter age">
                                            @error('age')
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
                                            <label for="nationality">
                                                <i class="fas fa-flag mr-1"></i>Nationality
                                            </label>
                                            <input type="text" class="form-control @error('nationality') is-invalid @enderror" id="nationality" name="nationality" value="{{ old('nationality', $user->nationality) }}" placeholder="Enter nationality">
                                            @error('nationality')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="current_residence">
                                                <i class="fas fa-home mr-1"></i>Current Residence
                                            </label>
                                            <input type="text" class="form-control @error('current_residence') is-invalid @enderror" id="current_residence" name="current_residence" value="{{ old('current_residence', $user->current_residence) }}" placeholder="Enter current residence">
                                            @error('current_residence')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="photo">
                                                <i class="fas fa-camera mr-1"></i>Profile Photo
                                            </label>
                                            @if($user->photo)
                                                <div class="mb-2">
                                                    <img src="{{ asset('storage/' . $user->photo) }}" alt="Current Photo" class="img-thumbnail" style="max-width: 150px; max-height: 150px;">
                                                </div>
                                            @endif
                                            <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo" accept="image/*">
                                            <small class="form-text text-muted">Upload a new photo (JPEG, PNG, JPG, max 2MB)</small>
                                            @error('photo')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-dumbbell mr-2"></i>Coaching Information
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="specialization">
                                                <i class="fas fa-star mr-1"></i>Specialization
                                            </label>
                                            <input type="text" class="form-control @error('specialization') is-invalid @enderror" id="specialization" name="specialization" value="{{ old('specialization', $user->specialization) }}" placeholder="e.g., Basketball, Strength Training">
                                            @error('specialization')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="experience">
                                                <i class="fas fa-calendar mr-1"></i>Years of Experience
                                            </label>
                                            <input type="number" min="0" max="50" class="form-control @error('experience') is-invalid @enderror" id="experience" name="experience" value="{{ old('experience', $user->experience) }}" placeholder="Enter years of experience">
                                            @error('experience')
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
                                            <label for="primary_sport">
                                                <i class="fas fa-trophy mr-1"></i>Primary Sport Coached
                                            </label>
                                            <input type="text" class="form-control @error('primary_sport') is-invalid @enderror" id="primary_sport" name="primary_sport" value="{{ old('primary_sport', $user->primary_sport) }}" placeholder="Enter primary sport coached">
                                            @error('primary_sport')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="certifications">
                                                <i class="fas fa-certificate mr-1"></i>Certifications (comma-separated)
                                            </label>
                                            <input type="text" class="form-control @error('certifications') is-invalid @enderror" id="certifications" name="certifications" value="{{ old('certifications', $user->certifications ? \App\Helpers\ArrayHelper::ensureArrayAndImplode($user->certifications) : '') }}" placeholder="e.g., NSCA-CSCS, USA Weightlifting">
                                            @error('certifications')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="education_level">
                                                <i class="fas fa-graduation-cap mr-1"></i>Education Level
                                            </label>
                                            <input type="text" class="form-control @error('education_level') is-invalid @enderror" id="education_level" name="education_level" value="{{ old('education_level', $user->education_level) }}" placeholder="e.g., Bachelor's in Sports Science">
                                            @error('education_level')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-1"></i>Update Profile
                            </button>
                            <a href="{{ route('coach.profile.index') }}" class="btn btn-secondary ml-2">
                                <i class="fas fa-times mr-1"></i>Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
