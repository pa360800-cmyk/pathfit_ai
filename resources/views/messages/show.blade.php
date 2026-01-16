@extends(Auth::user()->role === 'Coach' ? 'layouts.mastercoach' : 'layouts.masterathlete')

@section('title', 'Conversation with ' . $contact->name)

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <a href="{{ Auth::user()->role === 'Coach' ? route('coach.messages.index') : route('messages.index') }}" class="btn btn-sm btn-outline-secondary me-3">
                        <i class="fas fa-arrow-left me-1"></i> Back to Messages
                    </a>
                    <div class="avatar-circle me-3">
                        <span class="avatar-text">{{ substr($contact->name, 0, 1) }}</span>
                    </div>
                    <div>
                        <h5 class="mb-0">{{ $contact->name }}</h5>
                        <small class="text-muted">{{ $contact->role }}</small>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Messages Container -->
                    <div id="messages-container" class="messages-container mb-4">
                        @forelse($messages as $message)
                            <div class="message {{ $message->sender_id === Auth::id() ? 'message-sent' : 'message-received' }}">
                                <div class="message-content">
                                    <p class="mb-1">{{ $message->content }}</p>
                                    <small class="text-muted">{{ $message->created_at->format('M d, H:i') }}</small>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5">
                                <i class="fas fa-comments fa-2x text-muted mb-3"></i>
                                <p class="text-muted">No messages yet. Start the conversation!</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Message Form -->
                    <form action="{{ route('messages.store', $contact) }}" method="POST" class="message-form">
                        @csrf
                        <div class="input-group">
                            <input type="text"
                                   name="content"
                                   class="form-control"
                                   placeholder="Type your message..."
                                   maxlength="1000"
                                   required
                                   autocomplete="off">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-1"></i> Send
                            </button>
                        </div>
                        @error('content')
                            <div class="text-danger mt-1">{{ $error }}</div>
                        @enderror
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.messages-container {
    max-height: 500px;
    overflow-y: auto;
    padding: 15px;
    background-color: #f8f9fa;
    border-radius: 10px;
    margin-bottom: 20px;
}

.message {
    margin-bottom: 15px;
    display: flex;
}

.message-sent {
    justify-content: flex-end;
}

.message-received {
    justify-content: flex-start;
}

.message-content {
    max-width: 70%;
    padding: 10px 15px;
    border-radius: 18px;
    position: relative;
}

.message-sent .message-content {
    background-color: #007bff;
    color: white;
    border-bottom-right-radius: 5px;
}

.message-received .message-content {
    background-color: white;
    color: #333;
    border-bottom-left-radius: 5px;
    box-shadow: 0 1px 2px rgba(0,0,0,0.1);
}

.message-form {
    border-top: 1px solid #dee2e6;
    padding-top: 15px;
}

.message-form .input-group .form-control {
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
}

.message-form .input-group .btn {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
}

.avatar-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
}

.avatar-text {
    color: white;
    font-weight: bold;
    font-size: 16px;
}

/* Scroll to bottom on load */
.messages-container {
    scroll-behavior: smooth;
}
</style>

<script>
// Scroll to bottom of messages on page load
document.addEventListener('DOMContentLoaded', function() {
    const messagesContainer = document.getElementById('messages-container');
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
});
</script>
@endsection
