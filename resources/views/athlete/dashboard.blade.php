@extends('layouts.masterathlete')

@section('title')
    Athlete Dashboard
@endsection

@section('body')
<div class="content-wrapper" style="margin-top: -10px;">
    <style>
        .dashboard-container {
            padding: 1.5rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            max-width: 1200px;
            margin: 0 auto;
        }

        .dashboard-header {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            margin-top: 2rem;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .dashboard-header h1 {
            color: #667eea;
            font-size: 1.8rem;
            font-weight: 700;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .welcome-message {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1.5rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .welcome-message h2 {
            margin: 0 0 0.5rem 0;
            font-size: 1.5rem;
        }

        .welcome-message p {
            margin: 0;
            opacity: 0.9;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1rem;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }

        .stat-card h4 {
            font-size: 0.85rem;
            font-weight: 500;
            margin: 0 0 0.5rem 0;
            opacity: 0.9;
        }

        .stat-card .value {
            font-size: 1.8rem;
            font-weight: 700;
            margin: 0;
        }

        .stat-card .icon {
            font-size: 1.5rem;
            margin-bottom: 0.3rem;
        }

        .charts-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .chart-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        .chart-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .chart-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
        }

        .chart-card h3 {
            color: #333;
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1rem;
            padding-bottom: 0.8rem;
            border-bottom: 3px solid #667eea;
        }

        .chart-container {
            position: relative;
            height: 280px;
        }

        .chart-container-small {
            position: relative;
            height: 250px;
        }

        .full-width-chart {
            grid-column: 1 / -1;
        }

        @media (max-width: 1250px) {
            .dashboard-container {
                max-width: 100%;
                padding: 1rem;
            }
            
            .chart-row {
                grid-template-columns: 1fr;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .dashboard-header h1 {
                font-size: 1.5rem;
                flex-direction: column;
                align-items: flex-start;
            }

            .chart-container,
            .chart-container-small {
                height: 250px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Loading animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(15px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .chart-card, .stat-card {
            animation: fadeIn 0.5s ease-out forwards;
            opacity: 0;
        }

        .stat-card:nth-child(1) { animation-delay: 0.05s; }
        .stat-card:nth-child(2) { animation-delay: 0.1s; }
        .stat-card:nth-child(3) { animation-delay: 0.15s; }
        .stat-card:nth-child(4) { animation-delay: 0.2s; }
        .stat-card:nth-child(5) { animation-delay: 0.25s; }
        .stat-card:nth-child(6) { animation-delay: 0.3s; }
        .stat-card:nth-child(7) { animation-delay: 0.35s; }
        .chart-card:nth-child(1) { animation-delay: 0.4s; }
        .chart-card:nth-child(2) { animation-delay: 0.45s; }
        .chart-card:nth-child(3) { animation-delay: 0.5s; }

        /* Additional sections */
        .info-section {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .info-section h3 {
            color: #667eea;
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .activity-list {
            display: flex;
            flex-direction: column;
            gap: 0.8rem;
        }

        .activity-item {
            display: flex;
            align-items: center;
            padding: 0.8rem;
            background: #f8f9fa;
            border-radius: 8px;
            border-left: 4px solid #667eea;
        }

        .activity-icon {
            font-size: 1.2rem;
            margin-right: 0.8rem;
        }

        .activity-content {
            flex: 1;
        }

        .activity-title {
            font-weight: 600;
            color: #333;
            margin-bottom: 0.2rem;
        }

        .activity-meta {
            font-size: 0.85rem;
            color: #666;
        }

        .coach-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1.5rem;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .coach-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .coach-info h4 {
            margin: 0 0 0.3rem 0;
            font-size: 1.1rem;
        }

        .coach-info p {
            margin: 0;
            opacity: 0.9;
            font-size: 0.9rem;
        }

        .alert-card {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
            color: white;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        .alert-card.warning {
            background: linear-gradient(135deg, #ffa726 0%, #fb8c00 100%);
        }

        .alert-card h4 {
            margin: 0 0 0.5rem 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .achievements-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
        }

        .achievement-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1rem;
            border-radius: 10px;
            text-align: center;
        }

        .achievement-icon {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .achievement-title {
            font-weight: 600;
            margin-bottom: 0.3rem;
        }

        .achievement-desc {
            font-size: 0.85rem;
            opacity: 0.9;
        }
    </style>

    <div class="dashboard-container">
        <div class="dashboard-header">
            <h1>
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 7L12 3L4 7M20 7L12 11M20 7V17L12 21M12 11L4 7M12 11V21M4 7V17L12 21" stroke="#667eea" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Athlete Performance Dashboard
            </h1>


        </div>

        <div class="welcome-message">
            <h2>Welcome back, Athlete {{ $user->name }}! 🏃‍♂️</h2>
            <p>Track your progress, view your training sessions, and achieve your goals.</p>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="icon">🏃‍♂️</div>
                <h4>Training Sessions</h4>
                <div class="value">{{ $trainingSessions }}</div>
            </div>
            <div class="stat-card">
                <div class="icon">🏆</div>
                <h4>Personal Bests</h4>
                <div class="value">{{ $personalBests }}</div>
            </div>
            <div class="stat-card">
                <div class="icon">📈</div>
                <h4>Performance Score</h4>
                <div class="value">{{ $performanceScore }}%</div>
            </div>
            <div class="stat-card">
                <div class="icon">⏱️</div>
                <h4>Total Training Hours</h4>
                <div class="value">{{ $totalTrainingHours }}h</div>
            </div>
            <div class="stat-card">
                <div class="icon">📊</div>
                <h4>Avg Session Duration</h4>
                <div class="value">{{ $avgSessionDuration }}min</div>
            </div>
            <div class="stat-card">
                <div class="icon">🔥</div>
                <h4>Current Streak</h4>
                <div class="value">{{ $currentStreak }} days</div>
            </div>
            <div class="stat-card">
                <div class="icon">🎯</div>
                <h4>Weekly Progress</h4>
                <div class="value">{{ $weeklyProgress }}/{{ $weeklyGoal }}h</div>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="info-section">
            <h3>📅 Recent Activities</h3>
            <div class="activity-list">
                @forelse($recentActivities as $activity)
                <div class="activity-item">
                    <div class="activity-icon">🏃‍♂️</div>
                    <div class="activity-content">
                        <div class="activity-title">{{ $activity->activity_name ?? 'Training Session' }}</div>
                        <div class="activity-meta">{{ $activity->activity_date }} • {{ $activity->duration }} min • Performance: {{ $activity->performance_rating }}/10</div>
                    </div>
                </div>
                @empty
                <p style="color: #666; text-align: center; padding: 2rem;">No recent activities found.</p>
                @endforelse
            </div>
        </div>

        <!-- Upcoming Sessions & Coach Info -->
        <div class="chart-row">
            <div class="info-section">
                <h3>📅 Upcoming Sessions</h3>
                <div class="activity-list">
                    @forelse($upcomingSessions as $session)
                    <div class="activity-item">
                        <div class="activity-icon">📅</div>
                        <div class="activity-content">
                            <div class="activity-title">{{ $session->title ?? 'Training Session' }}</div>
                            <div class="activity-meta">{{ $session->date }} • {{ $session->time ?? 'TBD' }}</div>
                        </div>
                    </div>
                    @empty
                    <p style="color: #666; text-align: center; padding: 1rem;">No upcoming sessions scheduled.</p>
                    @endforelse
                </div>
            </div>

            <div class="info-section">
                <h3>👨‍🏫 Your Coach</h3>
                @if($coach)
                <div class="coach-card">
                    <div class="coach-avatar">{{ substr($coach->name, 0, 1) }}</div>
                    <div class="coach-info">
                        <h4>{{ $coach->name }}</h4>
                        <p>{{ $coach->specialization ?? 'Sports Coach' }}</p>
                        <p style="font-size: 0.8rem; opacity: 0.8;">Experience: {{ $coach->experience ?? 'N/A' }} years</p>
                    </div>
                </div>
                @else
                <p style="color: #666; text-align: center; padding: 2rem;">No coach assigned yet.</p>
                @endif
            </div>
        </div>



        <!-- Recent Achievements -->
        <div class="info-section">
            <h3>🏆 Recent Achievements</h3>
            <div class="achievements-grid">
                @forelse($recentAchievements as $achievement)
                <div class="achievement-card">
                    <div class="achievement-icon">{{ $achievement['icon'] }}</div>
                    <div class="achievement-title">{{ $achievement['title'] }}</div>
                    <div class="achievement-desc">{{ $achievement['description'] }}</div>
                    <small style="opacity: 0.8;">{{ $achievement['date'] }}</small>
                </div>
                @empty
                <div class="achievement-card" style="background: #f8f9fa; color: #666;">
                    <div class="achievement-icon">🎯</div>
                    <div class="achievement-title">Keep Training!</div>
                    <div class="achievement-desc">Achievements will appear here as you progress.</div>
                </div>
                @endforelse
            </div>
        </div>

        <div class="charts-grid">
            <div class="chart-card full-width-chart">
                <h3>📈  Training Progress</h3>
                <div class="chart-container">
                    <canvas id="barChart"></canvas>
                </div>
            </div>

            <div class="chart-row">
                <div class="chart-card">
                    <h3>🎯 Goal Achievement</h3>
                    <div class="chart-container-small">
                        <canvas id="pieChart"></canvas>
                    </div>
                </div>

                <div class="chart-card">
                    <h3>📊 Performance Trend</h3>
                    <div class="chart-container-small">
                        <canvas id="lineChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="chart-row">
                <div class="chart-card">
                    <h3>🎯 Skills Assessment</h3>
                    <div class="chart-container-small">
                        <canvas id="radarChart"></canvas>
                    </div>
                </div>

                <div class="chart-card">
                    <h3>⏱️ Time Distribution</h3>
                    <div class="chart-container-small">
                        <canvas id="doughnutChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="chart-card full-width-chart">
                <h3>📊 Performance Comparison</h3>
                <div class="chart-container">
                    <canvas id="comparisonChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Pass PHP data to JavaScript
        const trainingProgressData = @json($trainingProgress);
        const goalAchievementData = @json($goalAchievement);
        const performanceTrendData = @json($performanceTrend);
        const skillsData = @json($skillsData);
        const timeDistribution = @json($timeDistribution);
        const comparisonData = @json($comparisonData);

        // Bar Chart - Training Progress
        const barCtx = document.getElementById('barChart').getContext('2d');
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5', 'Week 6'],
                datasets: [{
                    label: 'Training Hours',
                    data: trainingProgressData,
                    backgroundColor: 'rgba(102, 126, 234, 0.8)',
                    borderColor: 'rgba(102, 126, 234, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Pie Chart - Goal Achievement
        const pieCtx = document.getElementById('pieChart').getContext('2d');
        new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: ['Completed', 'In Progress', 'Not Started'],
                datasets: [{
                    data: goalAchievementData,
                    backgroundColor: [
                        'rgba(102, 126, 234, 0.8)',
                        'rgba(118, 75, 162, 0.8)',
                        'rgba(255, 193, 7, 0.8)'
                    ],
                    borderColor: [
                        'rgba(102, 126, 234, 1)',
                        'rgba(118, 75, 162, 1)',
                        'rgba(255, 193, 7, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        // Line Chart - Performance Trend
        const lineCtx = document.getElementById('lineChart').getContext('2d');
        new Chart(lineCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Performance Score',
                    data: performanceTrendData,
                    backgroundColor: 'rgba(102, 126, 234, 0.2)',
                    borderColor: 'rgba(102, 126, 234, 1)',
                    borderWidth: 2,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100
                    }
                }
            }
        });

        // Radar Chart - Skills Assessment
        const radarCtx = document.getElementById('radarChart').getContext('2d');
        new Chart(radarCtx, {
            type: 'radar',
            data: {
                labels: ['Speed', 'Endurance', 'Strength', 'Agility', 'Technique', 'Mental'],
                datasets: [{
                    label: 'Current Level',
                    data: skillsData,
                    backgroundColor: 'rgba(102, 126, 234, 0.2)',
                    borderColor: 'rgba(102, 126, 234, 1)',
                    borderWidth: 2,
                    pointBackgroundColor: 'rgba(102, 126, 234, 1)',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: 'rgba(102, 126, 234, 1)'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    r: {
                        beginAtZero: true,
                        max: 10
                    }
                }
            }
        });

        // Doughnut Chart - Time Distribution
        const doughnutCtx = document.getElementById('doughnutChart').getContext('2d');
        new Chart(doughnutCtx, {
            type: 'doughnut',
            data: {
                labels: ['Training', 'Rest', 'Warm-up', 'Cool-down', 'Other'],
                datasets: [{
                    data: timeDistribution,
                    backgroundColor: [
                        'rgba(102, 126, 234, 0.8)',
                        'rgba(118, 75, 162, 0.8)',
                        'rgba(255, 193, 7, 0.8)',
                        'rgba(76, 175, 80, 0.8)',
                        'rgba(244, 67, 54, 0.8)'
                    ],
                    borderColor: [
                        'rgba(102, 126, 234, 1)',
                        'rgba(118, 75, 162, 1)',
                        'rgba(255, 193, 7, 1)',
                        'rgba(76, 175, 80, 1)',
                        'rgba(244, 67, 54, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // Bar Chart - Performance Comparison
        const comparisonCtx = document.getElementById('comparisonChart').getContext('2d');
        new Chart(comparisonCtx, {
            type: 'bar',
            data: {
                labels: ['This Month', 'Last Month', 'Average'],
                datasets: [{
                    label: 'Your Performance',
                    data: comparisonData.yourData,
                    backgroundColor: 'rgba(102, 126, 234, 0.8)',
                    borderColor: 'rgba(102, 126, 234, 1)',
                    borderWidth: 1
                }, {
                    label: 'Team Average',
                    data: comparisonData.teamAverage,
                    backgroundColor: 'rgba(118, 75, 162, 0.8)',
                    borderColor: 'rgba(118, 75, 162, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        position: 'top'
                    }
                }
            }
        });
    </script>

</div>
@endsection
