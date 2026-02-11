@extends('layouts.masterathlete')

@section('title')
    Assigned Coach
@endsection

@section('body')
<div class="content-wrapper" style="margin-top: -10px;">
    <style>
        .coach-container {
            padding: 1.5rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            max-width: 1200px;
            margin: 0 auto;
        }

        .coach-header {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            margin-top: 2rem;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .coach-header h1 {
            color: #667eea;
            font-size: 1.8rem;
            font-weight: 700;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .coach-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .coach-card h3 {
            color: #333;
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1rem;
            padding-bottom: 0.8rem;
            border-bottom: 3px solid #667eea;
        }

        .coach-profile {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .coach-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: #667eea;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            font-weight: bold;
            overflow: hidden;
        }

        .coach-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .coach-info h4 {
            margin: 0 0 0.5rem 0;
            color: #333;
        }

        .coach-info p {
            margin: 0;
            color: #666;
        }

        .contact-info {
            margin-top: 1rem;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .btn-contact {
            background-color: #667eea;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 1rem;
        }

        .btn-contact:hover {
            background-color: #5a67d8;
        }

        @media (max-width: 768px) {
            .coach-container {
                padding: 1rem;
            }

            .coach-profile {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>

    <div class="coach-container">
        <div class="coach-header">
            <h1>
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 21V19C20 17.9391 19.5786 16.9217 18.8284 16.1716C18.0783 15.4214 17.0609 15 16 15H8C6.93913 15 5.92172 15.4214 5.17157 16.1716C4.42143 16.9217 4 17.9391 4 19V21M16 7C16 9.20914 14.2091 11 12 11C9.79086 11 8 9.20914 8 7C8 4.79086 9.79086 3 12 3C14.2091 3 16 4.79086 16 7Z" stroke="#667eea" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                My Assigned Coach
            </h1>
        </div>

        <div class="coach-card">
            <h3>Coach Information</h3>
            @if($coach)
            <div class="coach-profile">
                <div class="coach-avatar">
                    @if($coach->photo)
                        <img src="{{ asset('storage/' . $coach->photo) }}" alt="{{ $coach->name }}">
                    @else
                        {{ substr($coach->name, 0, 2) }}
                    @endif
                </div>
                <div class="coach-info">
                    <h4>{{ $coach->name }}</h4>
                    <p>{{ $coach->role }}</p>
                    <p>Specialization: {{ $coach->specialization ?: 'Professional Athletics Coach' }}</p>
                </div>
            </div>

            <div class="contact-info">
                <div class="contact-item">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 4H20C21.1 4 22 4.9 22 6V18C22 19.1 21.1 20 20 20H4C2.9 20 2 19.1 2 18V6C2 4.9 2.9 4 4 4Z" stroke="#666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M22 6L12 13L2 6" stroke="#666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    {{ $coach->email }}
                </div>
                <div class="contact-item">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22 16.92V19.92C22 20.52 21.52 21 20.92 21C15.72 20.26 11.74 16.28 11 11.08C10.5 10.48 10 9.92 10 9.42C10 8.92 10.48 8.42 11 8.92C16.28 8.18 20.26 4.2 20.92 0C21.52 0 22 0.48 22 1.08V4.08C22 4.58 21.52 5.08 21.08 5.42L18.08 8.42C17.68 8.82 17.68 9.42 18.08 9.82L21.08 12.82C21.52 13.16 22 13.66 22 14.16V16.92Z" stroke="#666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Phone: Not available
                </div>
            </div>

            <button class="btn-contact">Contact Coach</button>
            @else
            <p>No coach assigned yet.</p>
            @endif
        </div>

        <div class="coach-card">
            <h3>Training Sessions with Coach</h3>
            <p>Upcoming and past training sessions with your assigned coach.</p>
            @if($trainingSchedules->count() > 0)
            <ul style="list-style: none; padding: 0;">
                @foreach($trainingSchedules as $schedule)
                <li style="padding: 0.5rem 0; border-bottom: 1px solid #eee;">
                    <strong>{{ $schedule->date->format('Y-m-d') }} {{ $schedule->start_time }}</strong> - {{ $schedule->title }}
                </li>
                @endforeach
            </ul>
            @else
            <p>No training sessions scheduled yet.</p>
            @endif
        </div>
    </div>
</div>
@endsection
