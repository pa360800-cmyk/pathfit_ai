@php
    use App\Models\Message;
    $curr_route = request()->route()->getName();
    $user = Auth::user();
    $dashboardActive = in_array($curr_route, ['athlete.dashboard']) ? 'active' : '';
    $trainingScheduleActive = in_array($curr_route, ['user.training-schedule']) ? 'active' : '';
    $assignedCoachActive = in_array($curr_route, ['user.assigned-coach']) ? 'active' : '';
    $reportActivityActive = in_array($curr_route, ['user.report-activity']) ? 'active' : '';
    $sportSuggestionActive = in_array($curr_route, ['athlete.sport-suggestion']) ? 'active' : '';
    $sessionSchedulesActive = in_array($curr_route, ['athlete.session-schedules.index']) ? 'active' : '';
    $messengerActive = in_array($curr_route, ['user.messenger']) ? 'active' : '';
    $profileActive = in_array($curr_route, ['athlete.profile.index']) ? 'active' : '';
    $unreadMessagesCount = Message::where('receiver_id', $user->id)->where('is_read', false)->count();
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
</style>

<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Dashboard Link -->
        <li class="nav-item">
            <a href="{{ route('athlete.dashboard') }}" class="nav-link {{ $dashboardActive }}">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Dashboard</p>
            </a>
        </li>

        <li class="nav-header">Training</li>

        <!-- Training Schedule -->
        <li class="nav-item">
            <a href="{{ route('user.training-schedule') }}" class="nav-link {{ $trainingScheduleActive }}">
                <i class="nav-icon fas fa-calendar-alt"></i>
                <p>Training Schedule</p>
            </a>
        </li>

        <!-- Session Schedules -->
        <li class="nav-item">
            <a href="{{ route('athlete.session-schedules.index') }}" class="nav-link {{ $sessionSchedulesActive }}">
                <i class="nav-icon fas fa-clock"></i>
                <p>Session Schedules</p>
            </a>
        </li>

        <!-- Assigned Coach -->
        <li class="nav-item">
            <a href="{{ route('user.assigned-coach') }}" class="nav-link {{ $assignedCoachActive }}">
                <i class="nav-icon fas fa-user-friends"></i>
                <p>Assigned Coach</p>
            </a>
        </li>

        <!-- Report Activity -->
        <li class="nav-item">
            <a href="{{ route('user.report-activity') }}" class="nav-link {{ $reportActivityActive }}">
                <i class="nav-icon fas fa-clipboard-list"></i>
                <p>Report Activity</p>
            </a>
        </li>

        <!-- Sport Suggestion -->
        <li class="nav-item">
            <a href="{{ route('athlete.sport-suggestion') }}" class="nav-link {{ $sportSuggestionActive }}">
                <i class="nav-icon fas fa-lightbulb"></i>
                <p>Sport Suggestion</p>
            </a>
        </li>

        <li class="nav-header">Communication</li>

        <!-- Messenger -->
        <li class="nav-item">
            <a href="{{ route('athlete.messages.index') }}" class="nav-link {{ $messengerActive }}">
                <i class="nav-icon fas fa-comments"></i>
                <p>
                    Messenger
                    @if($unreadMessagesCount > 0)
                        <span class="badge badge-info right" id="unread-messages-count">{{ $unreadMessagesCount }}</span>
                    @endif
                </p>
            </a>
        </li>

        <li class="nav-header">Account</li>

        <!-- Profile -->
        <li class="nav-item">
            <a href="{{ route('athlete.profile.index') }}" class="nav-link {{ $profileActive }}">
                <i class="nav-icon fas fa-user"></i>
                <p>Profile</p>
            </a>
        </li>

        <!-- Sign Out -->
        <li class="nav-item">
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="nav-link" style="background: none; border: none; padding: 0; color: inherit; text-decoration: none; width: 100%; text-align: left;">
                    <i class="nav-icon fas fa-sign-out-alt"></i>
                    <p>Sign Out</p>
                </button>
            </form>
        </li>
    </ul>
</nav>
