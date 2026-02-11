@extends('layouts.master')

@section('content')
<div class="content-wrapper">
    <h1>AI-Based Features</h1>
    <p>This is the AI-Based index page. Add your AI-related content here.</p>

    <div class="mt-4">
        <h2>AI Assistance for Athlete Assignment in Sports</h2>
        <p>Use AI to assist in assigning athletes to sports based on their profiles and performance data.</p>
        <form action="{{ route('admin.ai-based.run-assignment') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="btn btn-primary">Run AI Assignment</button>
        </form>
    </div>

    <div class="mt-4">
        <h2>AI Integration to Assist Athletes</h2>
        <p>AI-powered features to help athletes improve their performance and training.</p>
        <ul>
            <li><strong>Personalized Training Plans:</strong> AI analyzes athlete data to create customized training schedules.</li>
            <li><strong>Performance Analysis:</strong> Real-time feedback on form, technique, and progress.</li>
            <li><strong>Injury Prevention:</strong> Predictive analytics to identify potential injury risks.</li>
            <li><strong>Nutrition Recommendations:</strong> AI-suggested meal plans based on goals and health data.</li>
        </ul>
        <form action="{{ route('admin.ai-based.enable-assistance') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="btn btn-success">Enable AI Assistance for Athletes</button>
        </form>
    </div>

    @if(session('success'))
        <div class="alert alert-success mt-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger mt-4">
            {{ session('error') }}
        </div>
    @endif

    @if(session('assignments'))
        <div class="mt-4">
            <h3>AI Assignment Results</h3>
            <p class="text-info">Training schedules have been automatically created for all assignments.</p>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Athlete ID</th>
                            <th>Athlete Name</th>
                            <th>Assigned Sport</th>
                            <th>Assigned Coach</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(session('assignments') as $assignment)
                        <tr>
                            <td>{{ $assignment['athlete_id'] }}</td>
                            <td>{{ $assignment['athlete_name'] }}</td>
                            <td>{{ $assignment['sport_name'] }}</td>
                            <td>{{ $assignment['coach_name'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection
