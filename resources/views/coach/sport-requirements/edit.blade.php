@extends('layouts.mastercoach')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Sport Requirement</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('coach.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('coach.sport-requirements.index') }}">Sport Requirements</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('coach.sport-requirements.show', $sportRequirement) }}">Details</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">Edit Sport Requirement</h3>
                            <div class="card-tools">
                                <a href="{{ route('coach.sport-requirements.show', $sportRequirement) }}" class="btn btn-tool">
                                    <i class="fas fa-eye"></i> View Details
                                </a>
                                <a href="{{ route('coach.sport-requirements.index') }}" class="btn btn-tool">
                                    <i class="fas fa-arrow-left"></i> Back to List
                                </a>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('coach.sport-requirements.update', $sportRequirement) }}">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="sport_available_id">Sport <span class="text-danger">*</span></label>
                                            <select name="sport_available_id" id="sport_available_id" class="form-control @error('sport_available_id') is-invalid @enderror" required>
                                                <option value="">Select a sport</option>
                                                @foreach($sports as $sport)
                                                    <option value="{{ $sport->id }}" {{ old('sport_available_id', $sportRequirement->sport_available_id) == $sport->id ? 'selected' : '' }}>{{ $sport->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('sport_available_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="required_gender">Required Gender <span class="text-danger">*</span></label>
                                            <select name="required_gender" id="required_gender" class="form-control @error('required_gender') is-invalid @enderror" required>
                                                <option value="both" {{ old('required_gender', $sportRequirement->required_gender) == 'both' ? 'selected' : '' }}>Both</option>
                                                <option value="male" {{ old('required_gender', $sportRequirement->required_gender) == 'male' ? 'selected' : '' }}>Male</option>
                                                <option value="female" {{ old('required_gender', $sportRequirement->required_gender) == 'female' ? 'selected' : '' }}>Female</option>
                                            </select>
                                            @error('required_gender')
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
                                            <label for="min_age">Minimum Age</label>
                                            <input type="number" name="min_age" id="min_age" value="{{ old('min_age', $sportRequirement->min_age) }}" class="form-control @error('min_age') is-invalid @enderror" min="0">
                                            @error('min_age')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="max_age">Maximum Age</label>
                                            <input type="number" name="max_age" id="max_age" value="{{ old('max_age', $sportRequirement->max_age) }}" class="form-control @error('max_age') is-invalid @enderror" min="0">
                                            @error('max_age')
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
                                            <label for="min_height">Minimum Height (cm)</label>
                                            <input type="number" name="min_height" id="min_height" value="{{ old('min_height', $sportRequirement->min_height) }}" class="form-control @error('min_height') is-invalid @enderror" min="0" step="0.1">
                                            @error('min_height')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="max_height">Maximum Height (cm)</label>
                                            <input type="number" name="max_height" id="max_height" value="{{ old('max_height', $sportRequirement->max_height) }}" class="form-control @error('max_height') is-invalid @enderror" min="0" step="0.1">
                                            @error('max_height')
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
                                            <label for="min_weight">Minimum Weight (kg)</label>
                                            <input type="number" name="min_weight" id="min_weight" value="{{ old('min_weight', $sportRequirement->min_weight) }}" class="form-control @error('min_weight') is-invalid @enderror" min="0" step="0.1">
                                            @error('min_weight')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="max_weight">Maximum Weight (kg)</label>
                                            <input type="number" name="max_weight" id="max_weight" value="{{ old('max_weight', $sportRequirement->max_weight) }}" class="form-control @error('max_weight') is-invalid @enderror" min="0" step="0.1">
                                            @error('max_weight')
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
                                            <label for="min_experience_years">Minimum Experience Years</label>
                                            <input type="number" name="min_experience_years" id="min_experience_years" value="{{ old('min_experience_years', $sportRequirement->min_experience_years) }}" class="form-control @error('min_experience_years') is-invalid @enderror" min="0">
                                            @error('min_experience_years')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="required_level">Required Level</label>
                                            <select name="required_level" id="required_level" class="form-control @error('required_level') is-invalid @enderror">
                                                <option value="">Select level</option>
                                                <option value="beginner" {{ old('required_level', $sportRequirement->required_level) == 'beginner' ? 'selected' : '' }}>Beginner</option>
                                                <option value="intermediate" {{ old('required_level', $sportRequirement->required_level) == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                                <option value="advanced" {{ old('required_level', $sportRequirement->required_level) == 'advanced' ? 'selected' : '' }}>Advanced</option>
                                                <option value="professional" {{ old('required_level', $sportRequirement->required_level) == 'professional' ? 'selected' : '' }}>Professional</option>
                                            </select>
                                            @error('required_level')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="required_positions">Required Positions (comma-separated)</label>
                                    <textarea name="required_positions" id="required_positions" rows="3" class="form-control @error('required_positions') is-invalid @enderror" placeholder="e.g. Forward, Midfielder, Defender">{{ old('required_positions', is_array($sportRequirement->required_positions) ? implode(', ', $sportRequirement->required_positions) : $sportRequirement->required_positions) }}</textarea>
                                    @error('required_positions')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="preferred_attributes">Preferred Attributes (comma-separated)</label>
                                    <textarea name="preferred_attributes" id="preferred_attributes" rows="3" class="form-control @error('preferred_attributes') is-invalid @enderror" placeholder="e.g. Speed, Strength, Agility">{{ old('preferred_attributes', is_array($sportRequirement->preferred_attributes) ? implode(', ', $sportRequirement->preferred_attributes) : $sportRequirement->preferred_attributes) }}</textarea>
                                    @error('preferred_attributes')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="medical_restrictions">Medical Restrictions (comma-separated)</label>
                                    <textarea name="medical_restrictions" id="medical_restrictions" rows="3" class="form-control @error('medical_restrictions') is-invalid @enderror" placeholder="e.g. Asthma, Knee injury">{{ old('medical_restrictions', is_array($sportRequirement->medical_restrictions) ? implode(', ', $sportRequirement->medical_restrictions) : $sportRequirement->medical_restrictions) }}</textarea>
                                    @error('medical_restrictions')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="additional_notes">Additional Notes</label>
                                    <textarea name="additional_notes" id="additional_notes" rows="4" class="form-control @error('additional_notes') is-invalid @enderror" placeholder="Any additional requirements or notes">{{ old('additional_notes', $sportRequirement->additional_notes) }}</textarea>
                                    @error('additional_notes')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="is_active" value="1" class="custom-control-input" id="is_active" {{ old('is_active', $sportRequirement->is_active) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="is_active">Active</label>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-save"></i> Update Requirement
                                </button>
                                <a href="{{ route('coach.sport-requirements.index') }}" class="btn btn-secondary ml-2">
                                    <i class="fas fa-times"></i> Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
