
@extends('layouts.master')

@section('content')
<div class="content-wrapper">
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Player Status</h3>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <a href="#" class="btn btn-primary">Add New Player</a>
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
                    <tr>
                        <td>1</td>
                        <td>John Doe</td>
                        <td>Forward</td>
                        <td><span class="badge badge-success">Active</span></td>
                        <td>85%</td>
                        <td>
                            <a href="#" class="btn btn-sm btn-info">View</a>
                            <a href="#" class="btn btn-sm btn-warning">Edit</a>
                            <a href="#" class="btn btn-sm btn-danger">Delete</a>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Jane Smith</td>
                        <td>Midfielder</td>
                        <td><span class="badge badge-warning">Injured</span></td>
                        <td>70%</td>
                        <td>
                            <a href="#" class="btn btn-sm btn-info">View</a>
                            <a href="#" class="btn btn-sm btn-warning">Edit</a>
                            <a href="#" class="btn btn-sm btn-danger">Delete</a>
                        </td>
                    </tr>
                    <!-- Add more rows as needed -->
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>

@endsection
