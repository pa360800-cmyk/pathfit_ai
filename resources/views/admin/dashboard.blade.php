@extends('layouts.master')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Admin Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $totalUsers }}</h3>
                            <p>Total Users</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person"></i>
                        </div>
                        <a href="{{ route('admin.users.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $totalAthletes }}</h3>
                            <p>Total Athletes</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-running"></i>
                        </div>
                        <a href="{{ route('admin.athlete.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $totalCoaches }}</h3>
                            <p>Total Coaches</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <a href="{{ route('admin.coach.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $activityReports }}</h3>
                            <p>Activity Reports</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>


            <!-- Recent Users Table -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Recent Users</h3>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Created At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users->take(5) as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->role }}</td>
                                        <td>{{ $user->created_at->format('Y-m-d') }}</td>
                                    </tr>
                                    @endforeach
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

@section('scripts')
<script>
    // User Roles Chart
    const userRolesCtx = document.getElementById('userRolesChart').getContext('2d');
    new Chart(userRolesCtx, {
        type: 'pie',
        data: {
            labels: ['Administrators', 'Athletes', 'Coaches'],
            datasets: [{
                data: [{{ $totalAdmins }}, {{ $totalAthletes }}, {{ $totalCoaches }}],
                backgroundColor: ['#dc3545', '#28a745', '#ffc107'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });

    // Athletes by Sport Chart
    const athletesBySportCtx = document.getElementById('athletesBySportChart').getContext('2d');
    const athletesBySportLabels = @json($athletesBySport->pluck('primary_sport'));
    const athletesBySportData = @json($athletesBySport->pluck('count'));
    if (athletesBySportLabels.length === 0) {
        athletesBySportLabels.push('No Data');
        athletesBySportData.push(0);
    }
    new Chart(athletesBySportCtx, {
        type: 'bar',
        data: {
            labels: athletesBySportLabels,
            datasets: [{
                label: 'Number of Athletes',
                data: athletesBySportData,
                backgroundColor: '#17a2b8',
                borderColor: '#17a2b8',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Coaches by Specialization Chart
    const coachesBySpecializationCtx = document.getElementById('coachesBySpecializationChart').getContext('2d');
    const coachesBySpecializationLabels = @json($coachesBySpecialization->pluck('specialization'));
    const coachesBySpecializationData = @json($coachesBySpecialization->pluck('count'));
    if (coachesBySpecializationLabels.length === 0) {
        coachesBySpecializationLabels.push('No Data');
        coachesBySpecializationData.push(0);
    }
    new Chart(coachesBySpecializationCtx, {
        type: 'doughnut',
        data: {
            labels: coachesBySpecializationLabels,
            datasets: [{
                data: coachesBySpecializationData,
                backgroundColor: ['#ff6384', '#36a2eb', '#cc65fe', '#ffce56'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });

    // Activity Reports Chart
    const activityReportsCtx = document.getElementById('activityReportsChart').getContext('2d');
    new Chart(activityReportsCtx, {
        type: 'line',
        data: {
            labels: ['Total Reports', 'Recent Reports (7 days)'],
            datasets: [{
                label: 'Activity Reports',
                data: [{{ $activityReports }}, {{ $recentActivities }}],
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 2,
                fill: true
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Athlete Age Chart
    const athleteAgeCtx = document.getElementById('athleteAgeChart').getContext('2d');
    const athleteAges = @json($athleteAges);
    const ageLabels = ['10-15', '16-20', '21-25', '26-30', '31-35', '36-40', '41+'];
    const ageCounts = [0, 0, 0, 0, 0, 0, 0];
    athleteAges.forEach(age => {
        if (age >= 10 && age <= 15) ageCounts[0]++;
        else if (age >= 16 && age <= 20) ageCounts[1]++;
        else if (age >= 21 && age <= 25) ageCounts[2]++;
        else if (age >= 26 && age <= 30) ageCounts[3]++;
        else if (age >= 31 && age <= 35) ageCounts[4]++;
        else if (age >= 36 && age <= 40) ageCounts[5]++;
        else if (age > 40) ageCounts[6]++;
    });
    new Chart(athleteAgeCtx, {
        type: 'bar',
        data: {
            labels: ageLabels,
            datasets: [{
                label: 'Number of Athletes',
                data: ageCounts,
                backgroundColor: '#e74c3c',
                borderColor: '#e74c3c',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Athlete Gender Chart
    const athleteGenderCtx = document.getElementById('athleteGenderChart').getContext('2d');
    const athleteGenders = @json($athleteGenders);
    new Chart(athleteGenderCtx, {
        type: 'pie',
        data: {
            labels: Object.keys(athleteGenders),
            datasets: [{
                data: Object.values(athleteGenders),
                backgroundColor: ['#3498db', '#e74c3c', '#2ecc71'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });

    // Athlete Level Chart
    const athleteLevelCtx = document.getElementById('athleteLevelChart').getContext('2d');
    const athleteLevels = @json($athleteLevels);
    new Chart(athleteLevelCtx, {
        type: 'doughnut',
        data: {
            labels: Object.keys(athleteLevels),
            datasets: [{
                data: Object.values(athleteLevels),
                backgroundColor: ['#f39c12', '#9b59b6', '#1abc9c', '#34495e'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });

    // Coach Experience Chart
    const coachExperienceCtx = document.getElementById('coachExperienceChart').getContext('2d');
    const coachExperiences = @json($coachExperiences);
    new Chart(coachExperienceCtx, {
        type: 'bar',
        data: {
            labels: Object.keys(coachExperiences),
            datasets: [{
                label: 'Number of Coaches',
                data: Object.values(coachExperiences),
                backgroundColor: '#f1c40f',
                borderColor: '#f1c40f',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Coach Athlete Count Chart
    const coachAthleteCountCtx = document.getElementById('coachAthleteCountChart').getContext('2d');
    const coachAthleteCounts = @json($coachAthleteCounts);
    new Chart(coachAthleteCountCtx, {
        type: 'line',
        data: {
            labels: Array.from({length: coachAthleteCounts.length}, (_, i) => `Coach ${i+1}`),
            datasets: [{
                label: 'Athletes per Coach',
                data: coachAthleteCounts,
                backgroundColor: 'rgba(52, 152, 219, 0.2)',
                borderColor: 'rgba(52, 152, 219, 1)',
                borderWidth: 2,
                fill: true
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection
