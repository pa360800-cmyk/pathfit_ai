@extends('layouts.masterathlete')

@section('content')
<style>
    .schedule-container {
        padding: 1.5rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        max-width: 1200px;
        margin: 0 auto;
    }

    .schedule-header {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        margin-top: 2rem;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .schedule-header h1 {
        color: #667eea;
        font-size: 1.8rem;
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.8rem;
    }

    .schedule-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .schedule-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .table-modern {
        width: 100%;
        border-collapse: collapse;
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .table-modern thead th {
        background: #667eea;
        color: white;
        padding: 1rem;
        text-align: left;
        font-weight: 600;
    }

    .table-modern tbody tr {
        transition: background-color 0.3s ease;
    }

    .table-modern tbody tr:hover {
        background-color: #f8f9fa;
    }

    .table-modern tbody td {
        padding: 1rem;
        border-bottom: 1px solid #eee;
    }

    .table-modern tbody tr:last-child td {
        border-bottom: none;
    }

    .no-schedules {
        text-align: center;
        color: white;
        font-size: 1.2rem;
        padding: 3rem;
    }

    .no-schedules i {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.7;
    }

    .status-pending {
        color: #ffc107;
        font-weight: 500;
    }

    .status-confirmed {
        color: #28a745;
        font-weight: 500;
    }

    .status-cancelled {
        color: #dc3545;
        font-weight: 500;
    }
</style>

<div class="content-wrapper" style="margin-top: -10px;">
    <div class="schedule-header">
        <h1>
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 2L13.09 8.26L19 9L13.09 9.74L12 16L10.91 9.74L5 9L10.91 8.26L12 2Z" stroke="#667eea" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M19 15H18C17.45 15 17 15.45 17 16V20C17 20.55 17.45 21 18 21H22C22.55 21 23 20.55 23 20V16C23 15.45 22.55 15 22 15H21" stroke="#667eea" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M21 15V13C21 11.9 20.1 11 19 11H17C15.9 11 15 11.9 15 13V15" stroke="#667eea" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            My Session Schedules
        </h1>
    </div>

    <div class="schedule-card">
        <div class="table-responsive">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Coach</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Duration</th>
                        <th>Status</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sessionSchedules as $sessionSchedule)
                        <tr>
                            <td>{{ $sessionSchedule->id }}</td>
                            <td>{{ $sessionSchedule->title }}</td>
                            <td>{{ $sessionSchedule->coach->fname }} {{ $sessionSchedule->coach->lname }}</td>
                            <td>{{ $sessionSchedule->date }}</td>
                            <td>{{ $sessionSchedule->start_time }}</td>
                            <td>{{ $sessionSchedule->duration }} min</td>
                            <td class="status-{{ strtolower($sessionSchedule->status) }}">{{ ucfirst($sessionSchedule->status) }}</td>
                            <td>{{ $sessionSchedule->notes }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="no-schedules">
                                <i class="fas fa-calendar-times"></i>
                                <h3>No Session Schedules Found</h3>
                                <p>You don't have any session schedules assigned yet. Contact your coach to get started!</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
