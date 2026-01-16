@extends('layouts.mastercoach')

@section('content')
<div class="content-wrapper">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold">Create Sport Requirement</h3>
                        <a href="{{ route('coach.sport-requirements.index') }}"
                           class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Back to List
                        </a>
                    </div>

                    <form method="POST" action="{{ route('coach.sport-requirements.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="sport_available_id" class="block text-sm font-medium text-gray-700">Sport</label>
                            <select name="sport_available_id" id="sport_available_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                <option value="">Select a sport</option>
                                @foreach($sports as $sport)
                                    <option value="{{ $sport->id }}" {{ old('sport_available_id') == $sport->id ? 'selected' : '' }}>{{ $sport->name }}</option>
                                @endforeach
                            </select>
                            @error('sport_available_id')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="min_age" class="block text-sm font-medium text-gray-700">Minimum Age</label>
                                <input type="number" name="min_age" id="min_age" value="{{ old('min_age') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                @error('min_age')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label for="max_age" class="block text-sm font-medium text-gray-700">Maximum Age</label>
                                <input type="number" name="max_age" id="max_age" value="{{ old('max_age') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                @error('max_age')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="min_height" class="block text-sm font-medium text-gray-700">Minimum Height (cm)</label>
                                <input type="number" name="min_height" id="min_height" value="{{ old('min_height') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                @error('min_height')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label for="max_height" class="block text-sm font-medium text-gray-700">Maximum Height (cm)</label>
                                <input type="number" name="max_height" id="max_height" value="{{ old('max_height') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                @error('max_height')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="min_weight" class="block text-sm font-medium text-gray-700">Minimum Weight (kg)</label>
                                <input type="number" name="min_weight" id="min_weight" value="{{ old('min_weight') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                @error('min_weight')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label for="max_weight" class="block text-sm font-medium text-gray-700">Maximum Weight (kg)</label>
                                <input type="number" name="max_weight" id="max_weight" value="{{ old('max_weight') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                @error('max_weight')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="required_gender" class="block text-sm font-medium text-gray-700">Required Gender</label>
                            <select name="required_gender" id="required_gender" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                <option value="both" {{ old('required_gender', 'both') == 'both' ? 'selected' : '' }}>Both</option>
                                <option value="male" {{ old('required_gender') == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('required_gender') == 'female' ? 'selected' : '' }}>Female</option>
                            </select>
                            @error('required_gender')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="min_experience_years" class="block text-sm font-medium text-gray-700">Minimum Experience Years</label>
                            <input type="number" name="min_experience_years" id="min_experience_years" value="{{ old('min_experience_years') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            @error('min_experience_years')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="required_level" class="block text-sm font-medium text-gray-700">Required Level</label>
                            <select name="required_level" id="required_level" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Select level</option>
                                <option value="beginner" {{ old('required_level') == 'beginner' ? 'selected' : '' }}>Beginner</option>
                                <option value="intermediate" {{ old('required_level') == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                <option value="advanced" {{ old('required_level') == 'advanced' ? 'selected' : '' }}>Advanced</option>
                                <option value="professional" {{ old('required_level') == 'professional' ? 'selected' : '' }}>Professional</option>
                            </select>
                            @error('required_level')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="required_positions" class="block text-sm font-medium text-gray-700">Required Positions (comma-separated)</label>
                            <textarea name="required_positions" id="required_positions" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('required_positions') }}</textarea>
                            @error('required_positions')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="preferred_attributes" class="block text-sm font-medium text-gray-700">Preferred Attributes (comma-separated)</label>
                            <textarea name="preferred_attributes" id="preferred_attributes" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('preferred_attributes') }}</textarea>
                            @error('preferred_attributes')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="medical_restrictions" class="block text-sm font-medium text-gray-700">Medical Restrictions (comma-separated)</label>
                            <textarea name="medical_restrictions" id="medical_restrictions" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('medical_restrictions') }}</textarea>
                            @error('medical_restrictions')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="additional_notes" class="block text-sm font-medium text-gray-700">Additional Notes</label>
                            <textarea name="additional_notes" id="additional_notes" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('additional_notes') }}</textarea>
                            @error('additional_notes')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                <span class="ml-2 text-sm text-gray-700">Active</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-end">
                            <a href="{{ route('coach.sport-requirements.index') }}" class="mr-4 text-gray-600 hover:text-gray-900">Cancel</a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Create Requirement
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
