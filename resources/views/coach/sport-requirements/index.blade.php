@extends('layouts.mastercoach')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Sport Requirements Management</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('coach.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Sport Requirements</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    {{ session('success') }}
                </div>
            @endif

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Sport Requirements</h3>
                            <div class="card-tools">
                                <a href="{{ route('coach.sport-requirements.create') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus"></i> Add New Requirement
                                </a>
                            </div>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Sport</th>
                                        <th>Age Range</th>
                                        <th>Height Range</th>
                                        <th>Weight Range</th>
                                        <th>Gender</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($requirements as $requirement)
                                    <tr>
                                        <td>{{ $requirement->sport_name }}</td>
                                        <td>
                                            @if($requirement->min_age && $requirement->max_age)
                                                {{ $requirement->min_age }}-{{ $requirement->max_age }} years
                                            @elseif($requirement->min_age)
                                                {{ $requirement->min_age }}+
                                            @elseif($requirement->max_age)
                                                Up to {{ $requirement->max_age }}
                                            @else
                                                Any
                                            @endif
                                        </td>
                                        <td>
                                            @if($requirement->min_height && $requirement->max_height)
                                                {{ $requirement->min_height }}-{{ $requirement->max_height }} cm
                                            @elseif($requirement->min_height)
                                                {{ $requirement->min_height }} cm+
                                            @elseif($requirement->max_height)
                                                Up to {{ $requirement->max_height }} cm
                                            @else
                                                Any
                                            @endif
                                        </td>
                                        <td>
                                            @if($requirement->min_weight && $requirement->max_weight)
                                                {{ $requirement->min_weight }}-{{ $requirement->max_weight }} kg
                                            @elseif($requirement->min_weight)
                                                {{ $requirement->min_weight }} kg+
                                            @elseif($requirement->max_weight)
                                                Up to {{ $requirement->max_weight }} kg
                                            @else
                                                Any
                                            @endif
                                        </td>
                                        <td>{{ ucfirst($requirement->required_gender) }}</td>
                                        <td>
                                            <span class="badge {{ $requirement->is_active ? 'badge-success' : 'badge-danger' }}">
                                                {{ $requirement->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('coach.sport-requirements.show', $requirement) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                            <a href="{{ route('coach.sport-requirements.edit', $requirement) }}" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <form action="{{ route('coach.sport-requirements.toggle', $requirement) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn {{ $requirement->is_active ? 'btn-danger' : 'btn-success' }} btn-sm">
                                                    <i class="fas fa-{{ $requirement->is_active ? 'ban' : 'check' }}"></i>
                                                    {{ $requirement->is_active ? 'Deactivate' : 'Activate' }}
                                                </button>
                                            </form>
                                            <form action="{{ route('coach.sport-requirements.destroy', $requirement) }}" method="POST" class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this requirement?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            No sport requirements found.
                                            <a href="{{ route('coach.sport-requirements.create') }}" class="text-primary">Create your first requirement</a>
                                        </td>
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
