@extends('layouts.mastercoach')

@section('content')
<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title">Create Sport Requirement</h3>
                            <a href="{{ route('coach.sport-requirements.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to List
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('coach.sport-requirements.store') }}">
                            @csrf

                            <div class="form-group">
                                <label for="sport_available_id">Sport <span class="text-danger">*</span></label>
                                <select name="sport_available_id" id="sport_available_id" class="form-control @error('sport_available_id') is-invalid @enderror" required>
                                    <option value="">Select a sport</option>
                                    @foreach($sports as $sport)
                                        <option value="{{ $sport->id }}" {{ old('sport_available_id') == $sport->id ? 'selected' : '' }}>{{ $sport->name }}</option>
                                    @endforeach
                                </select>
                                @error('sport_available_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="min_age">Minimum Age</label>
                                        <input type="number" name="min_age" id="min_age" value="{{ old('min_age') }}" class="form-control @error('min_age') is-invalid @enderror">
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
                                        <input type="number" name="max_age" id="max_age" value="{{ old('max_age') }}" class="form-control @error('max_age') is-invalid @enderror">
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
                                        <input type="number" name="min_height" id="min_height" value="{{ old('min_height') }}" class="form-control @error('min_height') is-invalid @enderror">
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
                                        <input type="number" name="max_height" id="max_height" value="{{ old('max_height') }}" class="form-control @error('max_height') is-invalid @enderror">
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
                                        <input type="number" name="min_weight" id="min_weight" value="{{ old('min_weight') }}" class="form-control @error('min_weight') is-invalid @enderror">
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
                                        <input type="number" name="max_weight" id="max_weight" value="{{ old('max_weight') }}" class="form-control @error('max_weight') is-invalid @enderror">
                                        @error('max_weight')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="required_gender">Required Gender <span class="text-danger">*</span></label>
                                <select name="required_gender" id="required_gender" class="form-control @error('required_gender') is-invalid @enderror" required>
                                    <option value="both" {{ old('required_gender', 'both') == 'both' ? 'selected' : '' }}>Both</option>
                                    <option value="male" {{ old('required_gender') == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('required_gender') == 'female' ? 'selected' : '' }}>Female</option>
                                </select>
                                @error('required_gender')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="min_experience_years">Minimum Experience Years</label>
                                <input type="number" name="min_experience_years" id="min_experience_years" value="{{ old('min_experience_years') }}" class="form-control @error('min_experience_years') is-invalid @enderror">
                                @error('min_experience_years')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="required_level">Required Level</label>
                                <select name="required_level" id="required_level" class="form-control @error('required_level') is-invalid @enderror">
                                    <option value="">Select level</option>
                                    <option value="beginner" {{ old('required_level') == 'beginner' ? 'selected' : '' }}>Beginner</option>
                                    <option value="intermediate" {{ old('required_level') == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                    <option value="advanced" {{ old('required_level') == 'advanced' ? 'selected' : '' }}>Advanced</option>
                                    <option value="professional" {{ old('required_level') == 'professional' ? 'selected' : '' }}>Professional</option>
                                </select>
                                @error('required_level')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="required_positions">Required Positions (comma-separated)</label>
                                <textarea name="required_positions" id="required_positions" rows="3" class="form-control @error('required_positions') is-invalid @enderror">{{ old('required_positions') }}</textarea>
                                @error('required_positions')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="preferred_attributes">Preferred Attributes (comma-separated)</label>
                                <textarea name="preferred_attributes" id="preferred_attributes" rows="3" class="form-control @error('preferred_attributes') is-invalid @enderror">{{ old('preferred_attributes') }}</textarea>
                                @error('preferred_attributes')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="medical_restrictions">Medical Restrictions (comma-separated)</label>
                                <textarea name="medical_restrictions" id="medical_restrictions" rows="3" class="form-control @error('medical_restrictions') is-invalid @enderror">{{ old('medical_restrictions') }}</textarea>
                                @error('medical_restrictions')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="additional_notes">Additional Notes</label>
                                <textarea name="additional_notes" id="additional_notes" rows="4" class="form-control @error('additional_notes') is-invalid @enderror">{{ old('additional_notes') }}</textarea>
                                @error('additional_notes')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="is_active" value="1" class="custom-control-input" id="is_active" {{ old('is_active', true) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="is_active">Active</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Create Requirement
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
    </div>
</div>
@endsection
