@if(Auth::user()->role === 'Coach')
@extends('layouts.mastercoach')
@else
@extends('layouts.masterathlete')
@endif

@section('title', 'Messages')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="fas fa-comments me-2"></i>Messages
                    </h4>
                </div>

                <div class="card-body">
                    @forelse($contactsWithMessages as $contactData)
                        <div class="contact-item mb-3 p-3 border rounded">
                            <div class="d-flex align-items-center">
                                <div class="avatar-circle me-3">
                                    @if($contactData['contact']->photo)
                                        <img src="{{ asset('storage/' . $contactData['contact']->photo) }}" alt="{{ $contactData['contact']->name }}" class="avatar-img">
                                    @else
                                        <span class="avatar-text">{{ substr($contactData['contact']->name, 0, 1) }}</span>
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-1">
                                                <a href="{{ route('messages.show', $contactData['contact']) }}" class="text-decoration-none">
                                                    {{ $contactData['contact']->name }}
                                                </a>
                                                @if($contactData['unread_count'] > 0)
                                                    <span class="badge bg-danger ms-2">{{ $contactData['unread_count'] }}</span>
                                                @endif
                                            </h6>
                                            <small class="text-muted">{{ $contactData['contact']->role }}</small>
                                        </div>
                                        <small class="text-muted">
                                            @if($contactData['latest_message'])
                                                {{ $contactData['latest_message']->created_at->diffForHumans() }}
                                            @endif
                                        </small>
                                    </div>
                                    <p class="mb-0 text-muted small">
                                        @if($contactData['latest_message'])
                                            {{ Str::limit($contactData['latest_message']->content, 50) }}
                                        @else
                                            No messages yet
                                        @endif
                                    </p>
                                </div>
                                <div class="ms-3">
                                    <a href="{{ route('messages.show', $contactData['contact']) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye me-1"></i> View
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <i class="fas fa-inbox fa-2x text-muted mb-3"></i>
                            <h5 class="text-muted">No contacts available</h5>
                            <p class="text-muted">You don't have any contacts to message at the moment.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.contact-item {
    transition: background-color 0.2s ease;
}

.contact-item:hover {
    background-color: #f8f9fa;
}

.avatar-circle {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
}

.avatar-text {
    color: white;
    font-weight: bold;
    font-size: 18px;
}

.avatar-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
}
</style>
@endsection
