<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Browse Jobs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-dark text-white">
    <div class="container py-5">
        <h1 class="mb-4">Browse Jobs</h1>

        @if (!empty($jobs) && is_array($jobs))
            <div class="row g-3">
                @foreach ($jobs as $job)
                    <div class="col-md-6 col-lg-4">
                        <div class="card bg-secondary h-100">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">
                                    @if (isset($job['jobUrl']))
                                        <a href="{{ $job['jobUrl'] }}" target="_blank"
                                            class="text-white text-decoration-none">
                                            {{ $job['jobTitle'] ?? '-' }}
                                        </a>
                                    @else
                                        {{ $job['jobTitle'] ?? '-' }}
                                    @endif
                                </h5>

                                <p class="mb-1">
                                    <strong>Company:</strong>
                                    @if (isset($job['companyUrl']))
                                        <a href="{{ $job['companyUrl'] }}" target="_blank"
                                            class="text-white text-decoration-none">
                                            {{ $job['companyName'] ?? '-' }}
                                        </a>
                                    @else
                                        {{ $job['companyName'] ?? '-' }}
                                    @endif
                                </p>

                                @if (!empty($job['location']))
                                    <p class="mb-1"><strong>Location:</strong> {{ $job['location'] }}</p>
                                @endif

                                @if (!empty($job['postedTime']))
                                    <p class="mb-0"><small>Posted: {{ $job['postedTime'] }}</small></p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p>No jobs found.</p>
        @endif
    </div>
</body>

</html>
