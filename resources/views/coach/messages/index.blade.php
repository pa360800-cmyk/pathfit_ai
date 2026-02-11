@extends('layouts.mastercoach')

@section('title')
    Messages - Coach Dashboard
@endsection

@section('body')
<div class="content-wrapper" style="margin-top: -10px;">
    <style>
        .messages-container {
            padding: 1.5rem;
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            min-height: 100vh;
            max-width: 1200px;
            margin: 0 auto;
        }

        .messages-header {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            margin-top: 2rem;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .messages-title {
            margin: 0;
            color: #28a745;
            font-size: 1.8rem;
            font-weight: 600;
        }

        .messages-subtitle {
            margin: 0;
            color: #666;
            font-size: 0.9rem;
        }

        .contacts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 1.5rem;
        }

        .contact-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .contact-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        }

        .contact-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }

        .contact-card.unread {
            border-left: 4px solid #28a745;
        }

        .contact-header {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }

        .contact-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            position: relative;
            margin-right: 1rem;
            flex-shrink: 0;
        }

        .contact-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .contact-avatar .initials {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.5rem;
            border-radius: 50%;
        }

        .online-indicator {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 18px;
            height: 18px;
            background: #28a745;
            border: 3px solid white;
            border-radius: 50%;
        }

        .contact-info {
            flex: 1;
        }

        .contact-name {
            margin: 0 0 0.25rem 0;
            color: #28a745;
            font-size: 1.2rem;
            font-weight: 600;
        }

        .contact-role {
            margin: 0;
            color: #666;
            font-size: 0.85rem;
            background: #f8f9fa;
            padding: 0.25rem 0.5rem;
            border-radius: 12px;
            display: inline-block;
        }

        .contact-message {
            margin: 1rem 0;
            padding: 0.75rem;
            background: #f8f9fa;
            border-radius: 8px;
            border-left: 3px solid #28a745;
        }

        .message-text {
            margin: 0 0 0.5rem 0;
            color: #333;
            font-size: 0.9rem;
            line-height: 1.4;
        }

        .message-time {
            margin: 0;
            color: #666;
            font-size: 0.75rem;
        }

        .contact-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1rem;
        }

        .unread-badge {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.7; }
            100% { opacity: 1; }
        }

        .view-btn {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .view-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.4);
            color: white;
            text-decoration: none;
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            margin-top: 2rem;
        }

        .empty-state i {
            font-size: 4rem;
            color: #28a745;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .empty-state h4 {
            color: #28a745;
            margin-bottom: 0.5rem;
        }

        .empty-state p {
            color: #666;
            margin: 0;
        }

        @media (max-width: 768px) {
            .messages-container {
                padding: 1rem;
            }

            .messages-header {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }

            .contacts-grid {
                grid-template-columns: 1fr;
            }

            .contact-card {
                padding: 1rem;
            }

            .contact-header {
                flex-direction: column;
                text-align: center;
            }

            .contact-avatar {
                margin-right: 0;
                margin-bottom: 1rem;
            }
        }
    </style>

    <div class="messages-container">
        <div class="messages-header">
            <div>
                <h1 class="messages-title">
                    <i class="fas fa-comments me-2"></i>Messages
                </h1>
                <p class="messages-subtitle">Connect with your athletes</p>
            </div>
            <div class="stats">
                <span class="badge bg-success">{{ $contactsWithMessages->count() }} Athletes</span>
            </div>
        </div>

        @if($contactsWithMessages->count() > 0)
            <div class="contacts-grid">
                @foreach($contactsWithMessages as $contactData)
                    <div class="contact-card {{ $contactData['unread_count'] > 0 ? 'unread' : '' }}">
                        <div class="contact-header">
                            <div class="contact-avatar">
                                @if($contactData['contact']->photo)
                                    <img src="{{ asset('storage/' . $contactData['contact']->photo) }}" alt="{{ $contactData['contact']->name }}">
                                @else
                                    <div class="initials">{{ substr($contactData['contact']->name, 0, 1) }}{{ substr($contactData['contact']->surname ?? '', 0, 1) }}</div>
                                @endif
                                <div class="online-indicator"></div>
                            </div>
                            <div class="contact-info">
                                <h3 class="contact-name">{{ $contactData['contact']->name }} {{ $contactData['contact']->surname ?? '' }}</h3>
                                <p class="contact-role">{{ $contactData['contact']->role }}</p>
                            </div>
                        </div>

                        <div class="contact-message">
                            @if($contactData['latest_message'])
                                <p class="message-text">{{ Str::limit($contactData['latest_message']->content, 80) }}</p>
                                <p class="message-time">{{ $contactData['latest_message']->created_at->diffForHumans() }}</p>
                            @else
                                <p class="message-text">No messages yet. Start a conversation!</p>
                                <p class="message-time">Never</p>
                            @endif
                        </div>

                        <div class="contact-actions">
                            @if($contactData['unread_count'] > 0)
                                <span class="unread-badge">{{ $contactData['unread_count'] }} unread</span>
                            @else
                                <span class="text-muted">All caught up!</span>
                            @endif
                            <a href="{{ route('coach.messages.show', $contactData['contact']) }}" class="view-btn">
                                <i class="fas fa-eye me-1"></i> View Chat
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-users"></i>
                <h4>No Athletes Assigned</h4>
                <p>You don't have any athletes assigned to you yet. Contact your administrator to get athletes assigned.</p>
            </div>
        @endif
    </div>
</div>
@endsection
