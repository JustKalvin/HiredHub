<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - HiredHub</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            background-color: #f8f9fa;
            /* bg-light */
        }

        /* Custom CSS buat hero section */
        .hero-section {
            background-color: #172B4D;
            color: white;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">

    <div style="background-color: #172B4D">
        @include('components.header')
    </div>

    <main class="flex-grow-1">
        <x-chatbot />
        <section class="py-5 text-center hero-section">
            <div class="container py-5">
                <h1 class="display-4 fw-bold mb-3">Your Single Source of Truth for Jobs</h1>
                <p class="lead mb-4 mx-auto" style="max-width: 700px; opacity: 0.9;">
                    HiredHub aggregates real-time job openings from leading professional platforms,
                    bringing all opportunities into one efficient place.
                </p>
            </div>
        </section>

        <section class="container py-5">
            <div class="row text-center g-4">
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm p-4">
                        <div class="text-primary mb-3"><i class="fa-solid fa-layer-group fa-3x"></i></div>
                        <h4 class="fw-bold">All in One Place</h4>
                        <p class="text-muted">No need to switch between LinkedIn or Glints.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm p-4">
                        <div class="text-primary mb-3"><i class="fa-solid fa-bolt fa-3x"></i></div>
                        <h4 class="fw-bold">Real-Time Updates</h4>
                        <p class="text-muted">Get the latest vacancies instantly.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm p-4">
                        <div class="text-primary mb-3"><i class="fa-solid fa-bell fa-3x"></i></div>
                        <h4 class="fw-bold">Smart Reminders</h4>
                        <p class="text-muted">Never miss a deadline again.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-white py-5">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="fw-bold text-dark">Meet The Team</h2>
                    <p class="text-muted">The minds behind HiredHub</p>
                </div>

                <div class="row justify-content-center g-4">
                    <div class="col-6 col-md-4 col-lg-3 text-center">
                        <div class="rounded-circle bg-secondary mx-auto mb-3 overflow-hidden shadow-sm"
                            style="width: 120px; height: 120px;">
                            <img src="{{ asset('images/profile.png') }}" alt="Dara"
                                class="w-100 h-100 object-fit-cover">
                        </div>
                        <h5 class="fw-bold fs-5">Dara Oktaviana</h5>
                        <p class="text-primary small mb-0">2702360126</p>
                    </div>

                    <div class="col-6 col-md-4 col-lg-3 text-center">
                        <div class="rounded-circle bg-secondary  mx-auto mb-3 overflow-hidden shadow-sm border"
                            style="width: 120px; height: 120px;">
                            <img src="{{ asset('images/profile.png') }}" class="w-100 h-100 object-fit-cover">
                        </div>
                        <h5 class="fw-bold fs-5">Kalvin</h5>
                        <p class="text-primary small mb-0">2702238804</p>
                    </div>

                    <div class="col-6 col-md-4 col-lg-3 text-center">
                        <div class="rounded-circle bg-secondary  mx-auto mb-3 overflow-hidden shadow-sm border"
                            style="width: 120px; height: 120px;">
                            <img src="{{ asset('images/profile.png') }}" class="w-100 h-100 object-fit-cover">
                        </div>
                        <h5 class="fw-bold fs-5">Aliyah Jasmine Saliano</h5>
                        <p class="text-primary small mb-0">2702361500</p>
                    </div>

                    <div class="col-6 col-md-4 col-lg-3 text-center">
                        <div class="rounded-circle bg-secondary  mx-auto mb-3 overflow-hidden shadow-sm border"
                            style="width: 120px; height: 120px;">
                            <img src="{{ asset('images/profile.png') }}" class="w-100 h-100 object-fit-cover">
                        </div>
                        <h5 class="fw-bold fs-5">Risya Safira</h5>
                        <p class="text-primary small mb-0">2702351790</p>
                    </div>

                    <div class="col-6 col-md-4 col-lg-3 text-center">
                        <div class="rounded-circle bg-secondary  mx-auto mb-3 overflow-hidden shadow-sm border"
                            style="width: 120px; height: 120px;">
                            <img src="{{ asset('images/profile.png') }}" class="w-100 h-100 object-fit-cover">
                        </div>
                        <h5 class="fw-bold fs-5">Ashley Azzahra</h5>
                        <p class="text-primary small mb-0">2702340111</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="container py-5 text-center">
            <div class="p-5 rounded-3 text-white" style="background: linear-gradient(to right, #172B4D, #0d6efd);">
                <h2 class="fw-bold mb-3">Ready to find your dream job?</h2>
                <a class="btn btn-light btn-lg px-4 fw-bold text-primary" data-bs-toggle="collapse" href="#browseForm"
                    role="button">
                    Browse Jobs Now
                </a>
            </div>
        </section>

    </main>

    <x-footer />

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
