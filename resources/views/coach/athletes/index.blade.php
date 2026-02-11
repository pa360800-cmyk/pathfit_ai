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
                    <div class="card card-primary shadow-lg">
                        <div class="card-header bg-gradient-primary text-white">
                            <h3 class="card-title">
                                <i class="fas fa-users mr-2"></i>Athletes Matching Your Sport Specialization - Coach: {{ Auth::user()->name }}
                            </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
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
                                        <tr class="hover-row">
                                            <td><strong>{{ $athlete->name }}</strong></td>
                                            <td>{{ $athlete->email }}</td>
                                            <td>
                                                <span class="badge badge-info badge-pill px-3 py-2">
                                                    <i class="fas fa-trophy mr-1"></i>{{ $athlete->primary_sport ?? 'Not specified' }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge badge-warning badge-pill px-3 py-2">
                                                    <i class="fas fa-chart-line mr-1"></i>{{ $athlete->level ?? 'Not specified' }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($athlete->coach_id == Auth::id())
                                                    <span class="badge badge-success badge-pill px-3 py-2">
                                                        <i class="fas fa-check-circle mr-1"></i>Assigned to You
                                                    </span>
                                                @else
                                                    <span class="badge badge-secondary badge-pill px-3 py-2">
                                                        <i class="fas fa-clock mr-1"></i>Available
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="{{ route('coach.athletes.show', $athlete) }}" class="btn btn-info btn-sm shadow-sm" title="View Details">
                                                        <i class="fas fa-eye"></i> View
                                                    </a>
                                                    @if($athlete->coach_id == Auth::id())
                                                        <a href="{{ route('messages.show', $athlete) }}" class="btn btn-primary btn-sm shadow-sm" title="Message Athlete">
                                                            <i class="fas fa-envelope"></i> Message
                                                        </a>
                                                    @else
                                                        <form method="POST" action="{{ route('coach.assign-athlete', $athlete) }}" style="display: inline;">
                                                            @csrf
                                                            <button type="submit" class="btn btn-success btn-sm shadow-sm" title="Assign to Me">
                                                                <i class="fas fa-user-plus"></i> Assign
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-5">
                                                <div class="alert alert-info alert-dismissible fade show shadow-sm">
                                                    <i class="fas fa-info-circle fa-2x mb-3 text-info"></i>
                                                    <h5 class="alert-heading">No Athletes Found</h5>
                                                    <p>No athletes found matching your sport specialization.</p>
                                                    <hr>
                                                    <small class="text-muted">Create sport requirements to define your specialization areas.</small>
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
                        <div class="card-footer bg-light">
                            <div class="row">
                                <div class="col-md-6">
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Showing athletes whose primary sport matches your active sport requirements.
                                    </small>
                                </div>
                                <div class="col-md-6 text-right">
                                    <a href="{{ route('coach.sport-requirements.index') }}" class="btn btn-outline-primary btn-sm shadow-sm">
                                        <i class="fas fa-cog mr-1"></i> Manage Sport Requirements
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
