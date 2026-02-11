@php
    use App\Models\Message;
    $curr_route = request()->route()->getName();
    $user = Auth::user();
    $dashboardActive = in_array($curr_route, ['coach.dashboard']) ? 'active' : '';
    $athletesActive = in_array($curr_route, ['coach.list', 'coach.athletes.index', 'coach.athletes.show', 'coach.athletes.edit']) ? 'active' : '';
    $trainingSchedulesActive = in_array($curr_route, ['coach.training-schedules.index', 'coach.training-schedules.create', 'coach.training-schedules.show', 'coach.training-schedules.edit']) ? 'active' : '';
    $sessionSchedulesActive = in_array($curr_route, ['coach.session-schedules.index', 'coach.session-schedules.create', 'coach.session-schedules.show', 'coach.session-schedules.edit']) ? 'active' : '';
    $activityReportsActive = in_array($curr_route, ['coach.activity-reports.index']) ? 'active' : '';
    $sportRequirementsActive = in_array($curr_route, ['coach.sport-requirements.index', 'coach.sport-requirements.create', 'coach.sport-requirements.show', 'coach.sport-requirements.edit']) ? 'active' : '';
    $messagesActive = in_array($curr_route, ['coach.messages.index', 'user.messenger']) ? 'active' : '';
    $eventsActive = in_array($curr_route, ['coach.events.index', 'coach.events.create', 'coach.events.edit', 'coach.events.show']) ? 'active' : '';
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
    .btn-chat {
        background-color: #f8f9fa;
        border: 1px solid #ccc;
        padding: 3px 10px;
        font-size: 12px;
        color: #333;
        text-align: center;
        display: block;
        margin: 5px auto 10px;
        width: 90%;
        border-radius: 4px;
        transition: background-color 0.3s ease;
    }
    .btn-chat:hover {
        background-color: #e2e6ea;
        color: #000;
        text-decoration: none;
    }
</style>

<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">


        <li class="nav-header" style="color: rgb(0, 0, 0)">Main Navigation</li>

        <li class="nav-item">
            <a href="{{ route('coach.dashboard') }}" class="nav-link {{ $dashboardActive }}">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Dashboard</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('coach.athletes.index') }}" class="nav-link {{ $athletesActive }}">
                <i class="nav-icon fas fa-users"></i>
                <p>Athletes</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('coach.training-schedules.index') }}" class="nav-link {{ $trainingSchedulesActive }}">
                <i class="nav-icon fas fa-calendar-alt"></i>
                <p>Training Schedules</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('coach.session-schedules.index') }}" class="nav-link {{ $sessionSchedulesActive }}">
                <i class="nav-icon fas fa-clock"></i>
                <p>Session Schedules</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('coach.activity-reports.index') }}" class="nav-link {{ $activityReportsActive }}">
                <i class="nav-icon fas fa-chart-line"></i>
                <p>Activity Reports</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('coach.sport-requirements.index') }}" class="nav-link {{ $sportRequirementsActive }}">
                <i class="nav-icon fas fa-list-check"></i>
                <p>Sport Requirements</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('coach.events.index') }}" class="nav-link {{ $eventsActive }}">
                <i class="nav-icon fas fa-calendar-alt"></i>
                <p>Events</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('coach.messages.index') }}" class="nav-link {{ $messagesActive }}">
                <i class="nav-icon fa-solid fa-comments"></i>
                <p>
                    Messages
                    @if($unreadMessagesCount > 0)
                        <span class="badge bg-primary float-right" id="unread-messages-count">{{ $unreadMessagesCount }}</span>
                    @endif
                </p>
            </a>
        </li>

<li class="nav-header" style="color: rgb(0, 0, 0)">Account</li>
        <li class="nav-item">
            <a href="{{ route('coach.profile.index') }}" class="nav-link {{ in_array($curr_route, ['coach.profile.index']) ? 'active' : '' }}">
                <i class="nav-icon fa-solid fa-user"></i>
                <p>Profile</p>
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
