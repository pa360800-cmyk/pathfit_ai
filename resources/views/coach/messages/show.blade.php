@extends('layouts.mastercoach')

@section('title')
    Chat with {{ $contact->name }} - Coach Dashboard
@endsection

@section('body')
<div class="content-wrapper" style="margin-top: -10px;">
    <style>
        .chat-container {
            padding: 1.5rem;
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            min-height: 100vh;
            max-width: 1200px;
            margin: 0 auto;
        }

        .chat-header {
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

        .chat-header .contact-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .contact-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
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
            font-size: 1.5rem;
            border-radius: 50%;
        }

        .online-indicator {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 15px;
            height: 15px;
            background: #28a745;
            border: 3px solid white;
            border-radius: 50%;
        }

        .contact-details h3 {
            margin: 0 0 0.25rem 0;
            color: #28a745;
            font-size: 1.4rem;
            font-weight: 600;
        }

        .contact-details p {
            margin: 0;
            color: #666;
            font-size: 0.9rem;
        }

        .back-btn {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .back-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.4);
        }

        .chat-window {
            background: white;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            height: 600px;
        }

        .messages-area {
            flex: 1;
            padding: 1.5rem;
            overflow-y: auto;
            background: #f8f9fa;
        }

        .message {
            margin-bottom: 1rem;
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
        }

        .message.sent {
            flex-direction: row-reverse;
        }

        .message.sent .message-content {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            margin-left: auto;
        }

        .message.received .message-content {
            background: white;
            color: #333;
            margin-right: auto;
        }

        .message-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .message-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid white;
        }

        .message-avatar .initials {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 0.9rem;
            border-radius: 50%;
        }

        .message-content {
            max-width: 70%;
            padding: 0.75rem 1rem;
            border-radius: 18px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .message-content p {
            margin: 0 0 0.25rem 0;
            font-size: 0.9rem;
            line-height: 1.4;
        }

        .message-time {
            font-size: 0.75rem;
            opacity: 0.7;
            text-align: right;
        }

        .message.sent .message-time {
            text-align: left;
        }

        .message-status {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            margin-top: 0.25rem;
        }

        .message-status i {
            font-size: 0.7rem;
        }

        .message-input-area {
            border-top: 1px solid #e9ecef;
            padding: 1.5rem;
            background: white;
            border-radius: 0 0 12px 12px;
        }

        .message-form {
            display: flex;
            gap: 1rem;
            align-items: flex-end;
        }

        .message-input {
            flex: 1;
            border: 2px solid #e9ecef;
            border-radius: 25px;
            padding: 0.75rem 1.25rem;
            font-size: 0.9rem;
            resize: none;
            min-height: 45px;
            max-height: 120px;
            outline: none;
            transition: border-color 0.3s ease;
        }

        .message-input:focus {
            border-color: #28a745;
        }

        .send-btn {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            border: none;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .send-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.4);
        }

        .send-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .empty-chat {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            text-align: center;
            color: #666;
        }

        .empty-chat i {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .empty-chat h4 {
            margin-bottom: 0.5rem;
            color: #28a745;
        }

        @media (max-width: 768px) {
            .chat-header {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }

            .message-content {
                max-width: 85%;
            }

            .message-input-area {
                padding: 1rem;
            }
        }
    </style>

    <div class="chat-container">
        <div class="chat-header">
            <div class="contact-info">
                <div class="contact-avatar">
                    @if($contact->photo)
                        <img src="{{ asset('storage/' . $contact->photo) }}" alt="{{ $contact->name }}">
                    @else
                        <div class="initials">{{ substr($contact->name, 0, 1) }}{{ substr($contact->surname ?? '', 0, 1) }}</div>
                    @endif
                    <div class="online-indicator"></div>
                </div>
                <div class="contact-details">
                    <h3>{{ $contact->name }} {{ $contact->surname ?? '' }}</h3>
                    <p>Athlete</p>
                </div>
            </div>
            <button class="back-btn" onclick="window.location.href='{{ route('coach.messages.index') }}'">
                <i class="fas fa-arrow-left mr-2"></i>Back to Messages
            </button>
        </div>

        <div class="chat-window">
            <div class="messages-area" id="messagesArea">
                @if($messages->count() > 0)
                    @foreach($messages as $message)
                        <div class="message {{ $message->sender_id === auth()->id() ? 'sent' : 'received' }}">
                            @if($message->sender_id !== auth()->id())
                                <div class="message-avatar">
                                    @if($contact->photo)
                                        <img src="{{ asset('storage/' . $contact->photo) }}" alt="{{ $contact->name }}">
                                    @else
                                        <div class="initials">{{ substr($contact->name, 0, 1) }}</div>
                                    @endif
                                </div>
                            @endif
                            <div class="message-content">
                                <p>{{ $message->content }}</p>
                                <div class="message-time">
                                    {{ $message->created_at->format('M j, g:i A') }}
                                    @if($message->sender_id === auth()->id())
                                        <div class="message-status">
                                            <i class="fas fa-check-double text-success"></i>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            @if($message->sender_id === auth()->id())
                         
                            @endif
                        </div>
                    @endforeach
                @else
                    <div class="empty-chat">
                        <i class="fas fa-comments"></i>
                        <h4>Start a conversation</h4>
                        <p>Send your first message to begin chatting with your athlete</p>
                    </div>
                @endif
            </div>

            <div class="message-input-area">
                <form class="message-form" action="{{ route('coach.messages.store', $contact->id) }}" method="POST">
                    @csrf
                    <textarea
                        class="message-input"
                        name="content"
                        placeholder="Type your message here..."
                        rows="1"
                        required
                        onkeydown="if(event.key === 'Enter' && !event.shiftKey) { event.preventDefault(); this.form.submit(); }"
                    ></textarea>
                    <button type="submit" class="send-btn" id="sendBtn">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Auto scroll to bottom of messages
        document.addEventListener('DOMContentLoaded', function() {
            const messagesArea = document.getElementById('messagesArea');
            messagesArea.scrollTop = messagesArea.scrollHeight;
        });

        // Auto-resize textarea
        document.querySelector('.message-input').addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = Math.min(this.scrollHeight, 120) + 'px';
        });
    </script>
</div>
@endsection
