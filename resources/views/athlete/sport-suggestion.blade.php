@extends('layouts.masterathlete')

@section('title', 'AI Sport Suggestions')

@section('content')
<div class="content-wrapper">


    <div class="container">
        <!-- How It Works Card -->
        <div class="card shadow-sm mb-4 border-0">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-md-2 text-center">
                        <div class="icon-circle bg-info text-white mx-auto">
                            <i class="fas fa-cogs fa-2x"></i>
                        </div>
                    </div>
                    <div class="col-md-10">
                        <h5 class="card-title text-info mb-2">
                            <i class="fas fa-lightbulb"></i> How Our AI Works
                        </h5>
                        <p class="card-text mb-0">
                            Our advanced algorithm analyzes your physical attributes, experience level, current sport preferences,
                            and performance metrics to recommend the most suitable sports for your development and enjoyment.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        @if(count($suggestions) > 0)
            <!-- Suggestions Grid -->
            <div class="row">
                @foreach($suggestions as $index => $suggestion)
                    <div class="col-xl-4 col-lg-6 col-md-6 mb-4">
                        <div class="card h-100 sport-card {{ $index === 0 ? 'top-recommendation' : '' }} shadow-sm border-0">
                            @if($index === 0)
                                <div class="card-header bg-gradient-success text-white text-center py-3">
                                    <div class="ribbon">
                                        <span><i class="fas fa-crown"></i> TOP PICK</span>
                                    </div>
                                    <h5 class="card-title mb-0 font-weight-bold">
                                        <i class="fas fa-trophy mr-2"></i>{{ $suggestion['sport']->name }}
                                    </h5>
                                </div>
                            @else
                                <div class="card-header bg-light text-center py-3">
                                    <h5 class="card-title mb-0 font-weight-bold text-primary">
                                        {{ $suggestion['sport']->name }}
                                    </h5>
                                </div>
                            @endif

                            <div class="card-body d-flex flex-column">
                                <p class="card-text text-muted mb-3">{{ $suggestion['sport']->description }}</p>

                                <!-- Compatibility Score -->
                                <div class="compatibility-section mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="font-weight-bold text-dark">Compatibility</span>
                                        <span class="badge badge-pill badge-{{ $suggestion['score'] >= 80 ? 'success' : ($suggestion['score'] >= 60 ? 'warning' : 'secondary') }}">
                                            {{ $suggestion['score'] }}%
                                        </span>
                                    </div>
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar bg-gradient-{{ $suggestion['score'] >= 80 ? 'success' : ($suggestion['score'] >= 60 ? 'warning' : 'info') }}"
                                             role="progressbar"
                                             style="width: {{ min($suggestion['score'], 100) }}%"
                                             aria-valuenow="{{ $suggestion['score'] }}"
                                             aria-valuemin="0"
                                             aria-valuemax="100">
                                        </div>
                                    </div>
                                </div>

                                <!-- Reasons -->
                                <div class="reasons-section mb-3">
                                    <h6 class="font-weight-bold text-dark mb-2">
                                        <i class="fas fa-check-circle text-success mr-1"></i>Why This Sport?
                                    </h6>
                                    <ul class="list-unstyled">
                                        @foreach($suggestion['reasons'] as $reason)
                                            <li class="mb-1">
                                                <i class="fas fa-check text-success mr-2"></i>
                                                <small class="text-muted">{{ $reason }}</small>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>

                                <!-- Action Button -->
                                <div class="mt-auto">
                                    @if($index === 0)
                                        <button class="btn btn-success btn-block font-weight-bold sport-select-btn"
                                                onclick="selectSport('{{ $suggestion['sport']->name }}', {{ $suggestion['score'] }}, {{ $suggestion['sport']->id }}, this)"
                                                data-sport-id="{{ $suggestion['sport']->id }}">
                                            <i class="fas fa-play-circle mr-2"></i>Start Training
                                        </button>
                                    @else
                                        <button class="btn btn-secondary btn-block font-weight-bold disabled"
                                                disabled
                                                title="Select the top recommended sport first">
                                            <i class="fas fa-lock mr-2"></i>Locked
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Statistics Summary -->
            <div class="card shadow-sm border-0 mt-4">
                <div class="card-body p-4">
                    <h5 class="card-title text-center mb-4">
                        <i class="fas fa-chart-line mr-2"></i>Your Sport Compatibility Overview
                    </h5>
                    <div class="row text-center">
                        <div class="col-md-4">
                            <div class="stat-item">
                                <h3 class="text-primary">{{ count($suggestions) }}</h3>
                                <p class="text-muted mb-0">Sports Analyzed</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stat-item">
                                <h3 class="text-success">{{ $suggestions[0]['score'] ?? 0 }}%</h3>
                                <p class="text-muted mb-0">Best Match Score</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stat-item">
                                <h3 class="text-info">{{ round(collect($suggestions)->avg('score'), 1) }}%</h3>
                                <p class="text-muted mb-0">Average Score</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- No Suggestions State -->
            <div class="text-center py-5">
                <div class="empty-state">
                    <div class="icon-circle bg-warning text-white mx-auto mb-4">
                        <i class="fas fa-search fa-3x"></i>
                    </div>
                    <h3 class="text-muted mb-3">No Suggestions Available</h3>
                    <p class="text-muted mb-4 lead">
                        We need more information about your athletic profile to provide personalized sport recommendations.
                        Complete your profile to unlock AI-powered suggestions.
                    </p>
                    <a href="{{ route('athlete.profile.edit') }}" class="btn btn-warning btn-lg px-4 py-2">
                        <i class="fas fa-user-edit mr-2"></i>Complete Your Profile
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Training Modal -->
<div class="modal fade" id="trainingModal" tabindex="-1" role="dialog" aria-labelledby="trainingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="trainingModalLabel">
                    <i class="fas fa-dumbbell mr-2"></i>Start Training
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <div class="mb-3">
                    <i class="fas fa-running fa-4x text-primary mb-3"></i>
                </div>
                <h5 id="modalSportName"></h5>
                <p class="text-muted">Compatibility Score: <span id="modalScore" class="font-weight-bold text-primary"></span></p>
                <p>This feature is coming soon! Contact your coach to begin training in this sport.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" onclick="confirmSportSelection()">
                    <i class="fas fa-check mr-2"></i>Confirm Selection
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .bg-gradient-success {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    }

    .bg-gradient-warning {
        background: linear-gradient(135deg, #fcb045 0%, #fd1d1d 100%);
    }

    .bg-gradient-info {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .hero-section {
        border-radius: 0 0 2rem 2rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }

    .icon-circle {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .sport-card {
        border-radius: 1rem;
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .sport-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    }

    .top-recommendation {
        border: 3px solid #28a745 !important;
        position: relative;
    }

    .ribbon {
        position: absolute;
        top: -10px;
        right: -10px;
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
        color: white;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: bold;
        box-shadow: 0 2px 10px rgba(0,0,0,0.2);
    }

    .ribbon span {
        display: flex;
        align-items: center;
    }

    .compatibility-section .progress {
        border-radius: 10px;
        background-color: #e9ecef;
    }

    .stat-item h3 {
        font-size: 2.5rem;
        margin-bottom: 0.5rem;
    }

    .empty-state {
        max-width: 500px;
        margin: 0 auto;
    }

    .btn {
        border-radius: 25px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    .card {
        border-radius: 1rem;
    }

    .badge {
        font-size: 0.75rem;
    }

    @media (max-width: 768px) {
        .hero-section {
            text-align: center;
            padding: 2rem 1rem;
        }

        .display-4 {
            font-size: 2rem;
        }

        .stat-item h3 {
            font-size: 2rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    let currentSportId = null;
    let selectedSport = null;

    function selectSport(sportName, score, sportId, buttonElement) {
        // Show confirmation modal
        $('#modalSportName').text(`Confirm selection: ${sportName}`);
        $('#modalScore').text(`${score}%`);
        currentSportId = sportId;
        selectedSport = { name: sportName, score: score, id: sportId, button: buttonElement };
        $('#trainingModal').modal('show');
    }

    function confirmSportSelection() {
        if (selectedSport) {
            // Update the selected button
            $(selectedSport.button).removeClass('btn-success').addClass('btn-warning');
            $(selectedSport.button).html('<i class="fas fa-check mr-2"></i>Selected');
            $(selectedSport.button).prop('disabled', true);

            // Disable all other sport selection buttons
            $('.sport-select-btn').not(selectedSport.button).each(function() {
                $(this).removeClass('btn-success').addClass('btn-secondary');
                $(this).html('<i class="fas fa-lock mr-2"></i>Unavailable');
                $(this).prop('disabled', true);
            });

            // Disable all locked buttons as well
            $('.btn-secondary.disabled').prop('disabled', true);

            // Show success message
            showSuccessMessage(`You have selected ${selectedSport.name} for training!`);

            // Store selection (you can implement AJAX call here to save to database)
            // $.post('/athlete/select-sport', { sport_id: selectedSport.id }, function(response) {
            //     console.log('Sport selection saved');
            // });

            $('#trainingModal').modal('hide');
        }
    }

    function showTrainingModal(sportName, score, sportId) {
        $('#modalSportName').text(`Ready to start training in ${sportName}?`);
        $('#modalScore').text(`${score}%`);
        currentSportId = sportId;
        $('#trainingModal').modal('show');
    }

    function contactCoach() {
        if (currentSportId) {
            window.location.href = `/contact-sport-coach/${currentSportId}`;
        } else {
            alert('Unable to find coach for this sport.');
        }
        $('#trainingModal').modal('hide');
    }

    function showSuccessMessage(message) {
        // Create and show a success toast/message
        if ($('#successToast').length === 0) {
            $('body').append(`
                <div id="successToast" class="toast" style="position: fixed; top: 20px; right: 20px; z-index: 9999;">
                    <div class="toast-header bg-success text-white">
                        <strong class="mr-auto"><i class="fas fa-check-circle mr-2"></i>Success</strong>
                        <button type="button" class="ml-2 mb-1 close text-white" data-dismiss="toast">&times;</button>
                    </div>
                    <div class="toast-body">
                        ${message}
                    </div>
                </div>
            `);
        } else {
            $('#successToast .toast-body').text(message);
        }
        $('#successToast').toast({ delay: 5000 });
        $('#successToast').toast('show');
    }

    // Add smooth scrolling and animations
    $(document).ready(function() {
        // Animate cards on scroll
        $('.sport-card').each(function(i) {
            $(this).delay(i * 100).animate({opacity: 1, marginTop: 0}, 500);
        });

        // Initialize tooltips if needed
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
@endpush
