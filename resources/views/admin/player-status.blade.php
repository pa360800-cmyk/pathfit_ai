
@extends('layouts.master')

@section('content')
<div class="content-wrapper">
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Player Status</h3>
    </div>
    <div class="card-body">
        <div class="mb-12">
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Add New Player</a>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Status</th>
                        <th>Performance</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->position_role ?? 'N/A' }}</td>
                        <td>
                            @if(count($user->current_injuries ?? []) > 0)
                                <span class="badge badge-warning">Injured</span>
                            @else
                                <span class="badge badge-success">Active</span>
                            @endif
                        </td>
                        <td>
                            @php
                                $performance = match(strtolower($user->level ?? '')) {
                                    'beginner' => '60%',
                                    'intermediate' => '75%',
                                    'advanced' => '90%',
                                    default => '70%'
                                };
                            @endphp
                            {{ $performance }}
                        </td>
                        <td>
                            <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-sm btn-info">View</a>
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>

@endsection
