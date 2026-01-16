@extends('layouts.masterathlete')

@section('title')
    Messages - Athlete Dashboard
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
        }

        .messages-header h1 {
            color: #28a745;
            font-size: 1.8rem;
            font-weight: 700;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .messages-grid {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 1.5rem;
            margin-top: 1rem;
        }

        .contacts-list {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            max-height: 600px;
            overflow-y: auto;
        }

        .contact-item {
            display: flex;
            align-items: center;
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 0.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .contact-item:hover {
            background: rgba(40, 167, 69, 0.1);
            border-color: rgba(40, 167, 69, 0.3);
        }

        .contact-item.active {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            border-color: rgba(40, 167, 69, 0.8);
        }

        .contact-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 1rem;
            position: relative;
        }

        .contact-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
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
            font-size: 1.2rem;
            border-radius: 50%;
        }

        .online-indicator {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 12px;
            height: 12px;
            background: #28a745;
            border: 2px solid white;
            border-radius: 50%;
        }

        .contact-info h4 {
            margin: 0 0 0.25rem 0;
            font-size: 1rem;
            font-weight: 600;
        }

        .contact-info p {
            margin: 0;
            font-size: 0.85rem;
            opacity: 0.8;
        }

        .contact-item.active .contact-info p {
            opacity: 0.9;
        }

        .message-preview {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            min-height: 400px;
        }

        .message-preview i {
            font-size: 4rem;
            color: #28a745;
            margin-bottom: 1rem;
            opacity: 0.7;
        }

        .message-preview h3 {
            color: #28a745;
            margin-bottom: 0.5rem;
        }

        .message-preview p {
            color: #666;
            margin: 0;
        }

        .unread-badge {
            background: #dc3545;
            color: white;
            border-radius: 50%;
            padding: 0.2rem 0.5rem;
            font-size: 0.75rem;
            font-weight: bold;
            margin-left: auto;
        }

        @media (max-width: 768px) {
            .messages-grid {
                grid-template-columns: 1fr;
            }

            .contacts-list {
                max-height: 300px;
            }
        }
    </style>

    <div class="messages-container">
        <div class="messages-header">
            <h1>
                <i class="fas fa-comments"></i>
                Messages
            </h1>
        </div>

        <div class="messages-grid">
            <div class="contacts-list">
                <h4 style="margin-bottom: 1rem; color: #667eea;">Your Coach</h4>

                @forelse($contactsWithMessages as $contactData)
                    @php
                        $contact = $contactData['contact'];
                        $latestMessage = $contactData['latest_message'];
                        $unreadCount = $contactData['unread_count'];
                    @endphp
                    <div class="contact-item {{ request()->route('contact') == $contact->id ? 'active' : '' }}"
                         onclick="window.location.href='{{ route('athlete.messages.show', $contact->id) }}'">
                        <div class="contact-avatar">
                            @if($contact->photo)
                                <img src="{{ asset('storage/' . $contact->photo) }}" alt="{{ $contact->name }}">
                            @else
                                <div class="initials">{{ substr($contact->name, 0, 1) }}{{ substr($contact->surname ?? '', 0, 1) }}</div>
                            @endif
                            <div class="online-indicator"></div>
                        </div>
                        <div class="contact-info">
                            <h4>{{ $contact->name }} {{ $contact->surname ?? '' }}</h4>
                            <p>
                                @if($latestMessage)
                                    {{ Str::limit($latestMessage->content, 30) }}
                                @else
                                    No messages yet
                                @endif
                            </p>
                        </div>
                        @if($unreadCount > 0)
                            <div class="unread-badge">{{ $unreadCount }}</div>
                        @endif
                    </div>
                @empty
                    <div class="text-center" style="padding: 2rem; color: #666;">
                        <i class="fas fa-user-slash fa-3x mb-3"></i>
                        <p>No coach assigned yet</p>
                    </div>
                @endforelse
            </div>

            <div class="message-preview">
                <i class="fas fa-envelope-open-text"></i>
                <h3>Select a Conversation</h3>
                <p>Choose a contact from the list to start messaging</p>
            </div>
        </div>
    </div>
</div>
@endsection
