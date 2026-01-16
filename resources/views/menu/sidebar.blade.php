@php
    $curr_route = request()->route()->getName();
    $user = Auth::user();
    $dashboardActive = in_array($curr_route, ['admin.dashboard']) ? 'active' : '';
    $usersActive = in_array($curr_route, ['admin.users.index', 'admin.users.create', 'admin.users.edit']) ? 'active' : '';
    $coachActive = in_array($curr_route, ['admin.coach.index']) ? 'active' : '';
    $playerStatusActive = in_array($curr_route, ['admin.player-status']) ? 'active' : '';
    $trainingScheduleActive = in_array($curr_route, ['admin.training-schedule.index', 'admin.training-schedule.create', 'admin.training-schedule.edit']) ? 'active' : '';
    $profileActive = in_array($curr_route, ['admin.profile.index', 'admin.profile.edits']) ? 'active' : '';
    $sportActivityActive = in_array($curr_route, ['admin.sport-activity.index', 'admin.sport-activity.create', 'admin.sport-activity.edit']) ? 'active' : '';
    $sportAvailableActive = in_array($curr_route, ['admin.sport-available.index', 'admin.sport-available.create', 'admin.sport-available.edit']) ? 'active' : '';
    $assignCoachActive = in_array($curr_route, ['admin.assigncoach.index']) ? 'active' : '';
@endphp



<style>
    .nav-sidebar .nav-link {
        background: linear-gradient(135deg, #ffffff 0%, #eeebf1 100%);
        color: #fff;
        border-radius: 8px;
        margin: 5px 10px;
        padding: 10px 15px;
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        text-decoration: none;
        display: flex;
        align-items: center;
    }
    .nav-sidebar .nav-link:hover {
        background: linear-gradient(135deg, #1569d6 0%, #2649e4 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }
    .nav-sidebar .nav-link.active {
        background: linear-gradient(135deg, #075685 0%, #135ec0 100%);
        box-shadow: 0 4px 8px rgba(0,0,0,0.3);
    }
    .nav-sidebar .nav-link i {
        margin-right: 10px;
        font-size: 16px;
    }
    .nav-sidebar .nav-link p {
        font-size: 14px;
        font-weight: 500;
        margin: 0;
    }
    .nav-header {
        color: #333;
        font-weight: bold;
        font-size: 16px;
        margin: 20px 10px 10px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .nav-sidebar {
        padding: 10px 0;
    }
    .nav-sidebar .nav-item:last-child .nav-link {
        background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%);
    }
    .nav-sidebar .nav-item:last-child .nav-link:hover {
        background: linear-gradient(135deg, #fecfef 0%, #ff9a9e 100%);
    }
    .nav-link:active{
        background: linear-gradient(135deg, #075685 0%, #135ec0 100%);
        box-shadow: 0 4px 8px rgba(0,0,0,0.3);
    }
</style>

<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-header" style="color: rgb(0, 0, 0)">Main Navigation</li>

        <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ $dashboardActive }}">
                <i class="nav-icon fas fa-th"></i>
                <p>Dashboard</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('admin.users.index') }}" class="nav-link {{ $usersActive }}">
                <i class="nav-icon fas fa-users"></i>
                <p>Users Management</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('admin.coach.index') }}" class="nav-link {{ $coachActive }}">
                <i class="nav-icon fas fa-user-tie"></i>
                <p>Coaches</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('admin.player-status') }}" class="nav-link {{ $playerStatusActive }}">
                <i class="nav-icon fas fa-chart-line"></i>
                <p>Player Status</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('admin.training-schedule.index') }}" class="nav-link {{ $trainingScheduleActive }}">
                <i class="nav-icon fas fa-calendar-alt"></i>
                <p>Training Schedule</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.profile.index') }}" class="nav-link {{ $profileActive }}">
                <i class="nav-icon fas fa-user"></i>
                <p>Profile</p>
            </a>
        </li>
         <li class="nav-item">
            <a href="{{ route('admin.sport-activity.index') }}" class="nav-link {{ $sportActivityActive }}">
                <i class="nav-icon fas fa-running"></i>
                <p>Sport Activity</p>
            </a>
        </li>
       <li class="nav-item">
            <a href="{{ route('admin.sport-available.index') }}" class="nav-link {{ $sportAvailableActive }}">
                <i class="nav-icon fas fa-list"></i>
                <p>Sport Available</p>
            </a>
        </li>

         <li class="nav-item">
            <a href="{{ route('admin.assigncoach.index') }}" class="nav-link {{ $assignCoachActive }}">
                <i class="nav-icon fas fa-users"></i>
                <p>Coach Assign To The Sports</p>
            </a>
        </li>
        <li class="nav-item">
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="nav-link" style="background: none; border: none; padding: 0; color: inherit; text-decoration: none;">
                    <p><i class="fas fa-power-off"></i> Sign Out</p>
                </button>
            </form>
        </li>
    </ul>
</nav>
                        