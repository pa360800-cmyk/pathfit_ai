@extends('layouts.mastercoach')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Athletes by Sport Specialization</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('coach.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Athletes</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Athletes Matching Your Sport Specialization - Coach: {{ Auth::user()->name }}</h3>
                            <div class="card-tools">
                             
                            
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Primary Sport</th>
                                            <th>Level</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($athletes as $athlete)
                                        <tr>
                                            <td>{{ $athlete->name }}</td>
                                            <td>{{ $athlete->email }}</td>
                                            <td>
                                                <span class="badge badge-info">{{ $athlete->primary_sport ?? 'Not specified' }}</span>
                                            </td>
                                            <td>{{ $athlete->level ?? 'Not specified' }}</td>
                                            <td>
                                                @if($athlete->coach_id == Auth::id())
                                                    <span class="badge badge-success">Assigned to You</span>
                                                @else
                                                    <span class="badge badge-secondary">Available</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('coach.athletes.show', $athlete) }}" class="btn btn-sm btn-info" title="View Details">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    @if($athlete->coach_id == Auth::id())
                                                       
                                                        <a href="{{ route('messages.show', $athlete) }}" class="btn btn-sm btn-primary" title="Message Athlete">
                                                            <i class="fas fa-envelope"></i>
                                                        </a>
                                                    @else
                                                        <form method="POST" action="{{ route('coach.assign-athlete', $athlete) }}" style="display: inline;">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-success" title="Assign to Me">
                                                                <i class="fas fa-user-plus"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center">
                                                <div class="alert alert-info">
                                                    <i class="fas fa-info-circle"></i>
                                                    No athletes found matching your sport specialization.
                                                    <br>
                                                    <small>Create sport requirements to define your specialization areas.</small>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            @if($athletes->hasPages())
                                <div class="d-flex justify-content-center">
                                    {{ $athletes->links() }}
                                </div>
                            @endif
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-6">
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle"></i>
                                        Showing athletes whose primary sport matches your active sport requirements.
                                    </small>
                                </div>
                                <div class="col-md-6 text-right">
                                    <a href="{{ route('coach.sport-requirements.index') }}" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-cog"></i> Manage Sport Requirements
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
