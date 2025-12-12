<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Reminders</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body {
            background-color: white;
        }

        .card-job {
            background-color: #DAE1E9;
            /* Warna latar belakang card seperti contoh */
            border: none;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card-job:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .card-title a {
            color: #172B4D;
            text-decoration: none;
            font-weight: bold;
        }

        .card-title a:hover {
            text-decoration: underline;
        }

        .section-title {
            color: #172B4D;
            font-weight: bold;
        }

        .company-name {
            color: #5A6A80;
            font-size: 0.9rem;
        }

        .info-icon {
            color: #172B4D;
            margin-right: 5px;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">
    <x-chatbot />

    <div style="background-color: #172B4D">
        @include('components.header')
    </div>

    <div class="container py-5">

        <h1 class="mb-5 fw-bold section-title">🔔 Job Reminders</h1>

        @if (!empty($reminders))
            <div class="row g-4">
                @foreach ($reminders as $job)
                    <div class="col-md-6 col-lg-4">
                        <div class="card card-job h-100 shadow-lg border-0 rounded-4 p-4">

                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <span class="badge rounded-pill text-bg-primary"
                                    style="background-color: #172B4D !important; font-size: 0.9em;">
                                    #{{ $job['counter'] }}
                                </span>
                                <small class="text-muted">{{ $job['job_from'] ?? 'N/A' }}</small>
                            </div>

                            <h4 class="card-title mb-2" style="font-size: 1.2rem;">
                                <a href="{{ $job['job_url'] ?? '#' }}" target="_blank" title="View Job Details">
                                    {{ $job['job_title'] ?? 'Job Title Not Available' }}
                                </a>
                            </h4>

                            <p class="company-name mb-3">
                                <a href="{{ $job['company_url'] ?? '#' }}" target="_blank" class="text-secondary"
                                    style="text-decoration: none;">
                                    {{ $job['company_name'] ?? 'Company Name Not Available' }}
                                </a>
                            </p>

                            <div class="mt-auto">
                                <p class="card-text mb-1">
                                    <i class="fa-solid fa-location-dot info-icon"></i>
                                    <small
                                        class="text-secondary">{{ $job['location'] ?? 'Location Not Specified' }}</small>
                                </p>
                                <p class="card-text">
                                    <i class="fa-solid fa-clock info-icon"></i>
                                    <small class="text-secondary">Posted
                                        {{ $job['postedtime'] ?? 'Unknown Time' }}</small>
                                </p>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-info text-center mt-5" role="alert">
                <i class="fa-solid fa-bell-slash me-2"></i>
                <span class="fw-bold section-title">No job reminders found.</span>
            </div>
        @endif

    </div>

    <x-footer />

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
