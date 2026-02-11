@extends('layouts.mastercoach')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Athlete</th>
                                    <th>Activity Type</th>
                                    <th>Duration (minutes)</th>
                                    <th>Performance Rating</th>
                                    <th>Date</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($activityReports as $report)
                                <tr>
                                    <td>{{ $report->user->name }}</td>
                                    <td>{{ ucfirst($report->activity_type) }}</td>
                                    <td>{{ $report->duration }}</td>
                                    <td>{{ $report->performance_rating }}/10</td>
                                    <td>{{ $report->activity_date->format('M d, Y') }}</td>
                                    <td>{{ Str::limit($report->description, 50) }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">No activity reports found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $activityReports->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
