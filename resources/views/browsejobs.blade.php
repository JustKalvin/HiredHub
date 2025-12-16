<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Browse Jobs - HiredHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary-dark: #172B4D;
            --secondary-gray: #5E6C84;
            --bg-light: #F4F5F7;
        }

        body {
            background-color: var(--bg-light);
            color: var(--primary-dark);
        }

        /* --- STYLES UNTUK JOB CARD (KARTU KERJA) --- */
        .job-card {
            background: #fff;
            border: 1px solid #EBECF0;
            border-radius: 12px;
            padding: 24px;
            height: 100%;
            transition: all 0.2s ease-in-out;
            position: relative;
            display: flex;
            flex-direction: column;
        }

        .job-card:hover {
            border-color: var(--primary-dark);
            box-shadow: 0 8px 16px rgba(23, 43, 77, 0.1);
            transform: translateY(-2px);
        }

        .company-logo-placeholder {
            width: 50px;
            height: 50px;
            background-color: var(--primary-dark);
            color: white;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: 700;
            flex-shrink: 0;
        }

        .badge-custom {
            background-color: #DFE1E6;
            color: var(--primary-dark);
            font-weight: 600;
            font-size: 0.75rem;
            padding: 5px 10px;
            border-radius: 100px;
            display: inline-block;
        }

        .btn-details {
            background-color: var(--primary-dark);
            color: white;
            font-weight: 600;
            border-radius: 8px;
            padding: 8px 20px;
            border: none;
            margin-top: auto;
            transition: background-color 0.2s;
        }

        .btn-details:hover {
            background-color: #0F1E36;
            color: #fff;
        }

        /* --- STYLES UNTUK MODAL (POPUP) --- */
        .description-placeholder {
            background-color: #F4F5F7;
            border-radius: 12px;
            padding: 20px;
            border-left: 4px solid var(--primary-dark);
        }

        .footer {
            margin-top: auto;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">
    <x-chatbot />
    
    {{-- Header --}}
    <div style="background-color: #172B4D">
        @include('components.header')
    </div>

    <div class="container py-5">
        {{-- Judul Halaman --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="fw-bold mb-0" style="color: #172B4D">Browse Jobs</h1>
                <p class="text-muted">Result for: <strong>{{ $keywords }}</strong> inside <strong>{{ $geoId }}</strong></p>
            </div>

            {{-- Tombol Remind Me --}}
            <!-- <form action="{{ route('remind') }}" method="POST">
                @csrf
                <input type="text" name="keywords" value="{{ $keywords }}" hidden>
                <input type="text" name="geoId" value="{{ $geoId }}" hidden>
                <button class="btn btn-outline-dark fw-bold" type="submit">
                    <i class="fa-regular fa-bell me-2"></i> Remind Me
                </button>
            </form> -->
            <form action="{{ route('remind') }}" method="POST">
    @csrf
    {{-- Pastikan value-nya mengambil variabel $keywords dari controller --}}
    <input type="text" name="keywords" value="{{ $keywords ?? '' }}" hidden>
    <input type="text" name="geoId" value="{{ $geoId ?? '' }}" hidden>
    
    <button class="btn btn-outline-dark fw-bold" type="submit">
        <i class="fa-regular fa-bell me-2"></i> Remind Me
    </button>
</form>

        </div>

        {{-- Cek Data Jobs --}}
        @if (!empty($jobs) && (is_array($jobs) || $jobs instanceof \Illuminate\Support\Collection))

            {{-- Grouping Berdasarkan Platform (LinkedIn, Glints, dll) --}}
            @foreach (collect($jobs)->groupBy('from') as $from => $jobList)
                
                <h3 class="text-capitalize mt-5 mb-3 fw-bold" style="color: #172B4D">
                    <i class="fa-solid fa-layer-group me-2"></i> {{ $from }}
                </h3>

                <div class="row g-4">
                    @foreach ($jobList as $index => $job)
                        @php
                            // --- LOGIKA PEMBERSIH & PERSIAPAN DATA ---
                            $companyName = $job['companyName'] ?? 'Unknown Company';
                            $location = $job['location'] ?? 'Location not specified';
                            $jobTitle = $job['jobTitle'] ?? 'Job Title'; // <--- Kita bersihkan ini juga
                            $postedTime = $job['postedTime'] ?? 'Recently';

                            // 1. Bersihkan Nama Perusahaan
                            if (str_contains($companyName, '*') || str_contains($companyName, '\*')) {
                                $companyName = 'Confidential Company';
                            }

                            // 2. Bersihkan Lokasi
                            if (str_contains($location, '*') || str_contains($location, '\*')) {
                                $location = 'Location Hidden';
                            }
                            
                            // 3. [BARU] Bersihkan Judul Pekerjaan
                            if (str_contains($jobTitle, '*') || str_contains($jobTitle, '\*')) {
                                $jobTitle = 'Confidential Position'; // Ganti jadi teks rapi
                            }

                            // Buat ID unik untuk Modal
                            $modalId = 'jobModal-' . \Illuminate\Support\Str::slug($from) . '-' . $loop->parent->index . '-' . $index;
                        @endphp

                        <div class="col-md-6 col-lg-4">
                            {{-- === KARTU KERJA (UI BARU) === --}}
                            <div class="job-card">
                                {{-- Bagian Atas: Logo & Judul --}}
                                <div class="d-flex gap-3 mb-3">
                                    <div class="company-logo-placeholder shadow-sm">
                                        {{ strtoupper(substr($companyName, 0, 1)) }}
                                    </div>
                                    <div style="overflow: hidden;">
                                        <h5 class="fw-bold mb-1 text-truncate" title="{{ $jobTitle }}">
                                            {{ $jobTitle }}
                                        </h5>
                                        <div class="text-muted small text-truncate">{{ $companyName }}</div>
                                    </div>
                                </div>

                                {{-- Bagian Tengah: Tags --}}
                                <div class="mb-3">
                                    <span class="badge-custom"><i class="fa-solid fa-clock me-1"></i> Full Time</span>
                                    <span class="badge-custom">
                                        <i class="fa-solid fa-location-dot me-1"></i> 
                                        {{ \Illuminate\Support\Str::limit($location, 15) }}
                                    </span>
                                </div>

                                {{-- Bagian Bawah: Waktu & Tombol --}}
                                <div class="mt-auto d-flex flex-column gap-2">
                                    <small class="text-muted"><i class="fa-regular fa-calendar me-1"></i> Posted: {{ $postedTime }}</small>
                                    
                                    {{-- Tombol DETAILS (Memicu Modal) --}}
                                    <button type="button" class="btn btn-details w-100" data-bs-toggle="modal" data-bs-target="#{{ $modalId }}">
                                        Details
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- === MODAL POPUP (DETAILS) === --}}
                        <div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content border-0 rounded-4">
                                    <div class="modal-header border-0 pb-0">
                                        <h5 class="modal-title fw-bold">Job Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body p-4">
                                        {{-- Header Modal --}}
                                        <div class="d-flex align-items-center gap-3 mb-4">
                                            <div class="company-logo-placeholder" style="width: 60px; height: 60px; font-size: 24px;">
                                                {{ strtoupper(substr($companyName, 0, 1)) }}
                                            </div>
                                            <div>
                                                <h3 class="fw-bold mb-0 text-primary">{{ $jobTitle }}</h3>
                                                <p class="text-muted mb-0 fs-5">{{ $companyName }}</p>
                                            </div>
                                        </div>

                                        {{-- Info Grid --}}
                                        <div class="row mb-4">
                                            <div class="col-md-6 mb-2">
                                                <strong>Location:</strong> <br> {{ $location }}
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <strong>Posted On:</strong> <br> {{ $from }} • {{ $postedTime }}
                                            </div>
                                        </div>

                                        {{-- Placeholder Deskripsi --}}
                                        <h5 class="fw-bold mb-3">Description</h5>
                                        <div class="description-placeholder mb-4">
                                            <p class="mb-2"><strong><i class="fa-solid fa-circle-info me-2"></i> Full details are on the official site.</strong></p>
                                            <p class="text-muted mb-3">
                                                To view the complete job description, requirements, and benefits, please visit the official job posting on <strong>{{ ucfirst($from) }}</strong>. Applying directly ensures your application is tracked correctly.
                                            </p>
                                            <ul class="text-muted small">
                                                <li>Check specific requirements on the source site.</li>
                                                <li>Prepare your resume and portfolio.</li>
                                            </ul>
                                        </div>

                                        {{-- Tombol Apply --}}
                                        <div class="d-grid">
                                            <a href="{{ $job['jobUrl'] ?? '#' }}" target="_blank" class="btn btn-dark btn-lg fw-bold">
                                                Apply on {{ ucfirst($from) }} <i class="fa-solid fa-arrow-up-right-from-square ms-2"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- === END MODAL === --}}

                    @endforeach
                </div>
            @endforeach

        @else
            {{-- State Kosong --}}
            <div class="text-center py-5 my-5 bg-white rounded-4 shadow-sm border">
                <i class="fa-solid fa-magnifying-glass fa-4x text-muted mb-4"></i>
                <h3 class="fw-bold" style="color: #172B4D">No jobs found.</h3>
                <p class="text-muted">We couldn't find any jobs matching your criteria.</p>
                <a href="{{ route('home') }}" class="btn btn-dark mt-2">Try searching again</a>
            </div>
        @endif
    </div>

    {{-- Footer --}}
    <footer class="footer">
        @include('components.footer')
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>