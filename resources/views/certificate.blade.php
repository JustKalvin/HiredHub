<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find Certificate - HiredHub</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary-dark: #172B4D;
            --bg-light: #F4F5F7;
        }

        body {
            background-color: var(--bg-light);
            color: var(--primary-dark);
        }

        .section-title {
            color: var(--primary-dark);
            font-weight: bold;
        }

        /* --- STYLES UNTUK CARD SERTIFIKAT --- */
        .certificate-card {
            background-color: #ffffff; /* Putih bersih */
            border: 1px solid #EBECF0;
            border-radius: 12px;
            transition: all 0.2s ease-in-out;
            padding: 20px;
        }
        
        .certificate-card:hover {
            border-color: var(--primary-dark);
            box-shadow: 0 4px 12px rgba(23, 43, 77, 0.08);
            transform: translateY(-2px);
        }

        .initial-badge {
            width: 45px;
            height: 45px;
            background-color: var(--primary-dark);
            color: white;
            border-radius: 8px; /* Lebih kotak tapi sudut melengkung */
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: bold;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .certificate-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--primary-dark);
            text-decoration: none;
            transition: color 0.2s;
        }

        .certificate-title:hover {
            color: #0F1E36;
            text-decoration: underline;
        }
        
        .btn-open {
            background-color: var(--primary-dark);
            color: white;
            border-radius: 8px;
            font-weight: 600;
            padding: 8px 15px;
            transition: background-color 0.2s;
        }
        
        .btn-open:hover {
            background-color: #0F1E36;
        }
        
        .search-input {
            border-radius: 8px;
            border: 1px solid #DFE1E6;
            padding: 10px 15px;
        }
        /* --- LOADING OVERLAY STYLES (Tambahan CSS) --- */
        #loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.95); /* Layer putih transparan */
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            flex-direction: column;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s, visibility 0.3s;
        }

        #loading-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .spinner-border {
            width: 3rem;
            height: 3rem;
            color: var(--primary-dark) !important;
        }
        
        .loading-text {
            color: var(--primary-dark);
            font-size: 1.2rem;
            font-weight: 600;
            margin-top: 15px;
        }
        
        .loading-message {
             /* Pastikan warna primary dark sudah didefinisikan di :root atau style lain */
             color: #172B4D; 
             font-weight: bold;
        }

    </style>
</head>

<body class="d-flex flex-column min-vh-100">
    {{-- === LOADING OVERLAY (DITAMBAH HTML) === --}}
    <div id="loading-overlay">
        <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <div class="loading-text loading-message">
            Searching {!! isset($keyword) && !empty($keyword) ? "for '<strong>$keyword</strong>'" : "certificates" !!}...
        </div>
        <small class="text-muted mt-2">This may take up to 20 seconds while connecting to N8N.</small>
    </div>
    {{-- =================================== --}}

    <x-chatbot />
    
    <div style="background-color: #172B4D">
        @include('components.header')
    </div>
    
    <div class="container py-5">
        
        {{-- JUDUL DAN FORM PENCARIAN BARU --}}
        <h1 class="mb-4 fw-bold section-title"><i class="fa-solid fa-graduation-cap me-2"></i> Find Certificate</h1>

        <!-- <form action="{{ route('certificate.find') }}" method="POST" class="mb-5"> -->
            <form id="certificate-search-form" action="{{ route('certificate.find') }}" method="POST" class="mb-5">
            @csrf
            <div class="input-group input-group-lg shadow-sm">
                <input name="keyword" type="text" class="form-control search-input" 
                       placeholder="Search certificate by name or keyword..., ex AI, Machine Learning, etc." 
                       value="{{ $keyword ?? '' }}">
                <button class="btn btn-dark fw-bold px-4" type="submit">
                    <i class="fa-solid fa-magnifying-glass me-2"></i> Search
                </button>
            </div>
        </form>

        {{-- AREA HASIL PENCARIAN --}}
        @if (!empty($results))
            <h2 class="section-title mt-4 mb-4">Results for "{{ $keyword }}" ({{ count($results) }} found)</h2>

            <div class="row g-4">
                @foreach ($results as $item)
                    <div class="col-md-6 col-lg-4">
                        {{-- === CARD SERTIFIKAT BARU === --}}
                        <div class="certificate-card h-100 shadow-sm">

                            <div class="d-flex align-items-start gap-4">
                                {{-- Badge Inisial --}}
                                <div class="initial-badge flex-shrink-0">
                                    {{ isset($item['name']) ? strtoupper(substr($item['name'], 0, 1)) : '?' }}
                                </div>

                                <div class="flex-grow-1 d-flex flex-column justify-content-between">
                                    {{-- Judul Sertifikat (Link) --}}
                                    <h5 class="mb-3">
                                        <a href="{{ $item['url'] ?? '#' }}" target="_blank" class="certificate-title">
                                            {{ $item['name'] ?? 'Unknown Certificate' }}
                                        </a>
                                    </h5>
                                    
                                    {{-- Tombol Buka Sertifikat --}}
                                    <a href="{{ $item['url'] }}" target="_blank" class="btn btn-open w-100">
                                        <i class="fa-solid fa-arrow-up-right-from-square me-2"></i> Open Certificate
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
            
        @elseif (isset($keyword) && !empty($keyword))
            {{-- State: Keyword sudah dicari, tapi hasil kosong --}}
            <div class="text-center py-5 my-5 bg-white rounded-4 shadow-sm border">
                <i class="fa-solid fa-file-circle-xmark fa-4x text-muted mb-4"></i>
                <h3 class="fw-bold section-title">No matching certificate found.</h3>
                <p class="text-muted">Try searching with a different keyword.</p>
            </div>
        
        @else
            {{-- State: Belum ada pencarian --}}
            <div class="text-center py-5 my-5 bg-white rounded-4 shadow-sm border">
                <i class="fa-solid fa-magnifying-glass fa-4x text-muted mb-4"></i>
                <h3 class="fw-bold section-title">Start your search.</h3>
                <p class="text-muted">Find digital certificates from various platforms.</p>
            </div>
        @endif

    </div>
    <x-footer />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- === JAVASCRIPT UNTUK LOADING (DITAMBAH) === --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ambil form dengan ID baru
            const form = document.getElementById('certificate-search-form'); 
            const loadingOverlay = document.getElementById('loading-overlay');

            if (form) { // Pastikan form ada sebelum menambahkan event
                form.addEventListener('submit', function() {
                    // Aktifkan overlay saat form disubmit
                    loadingOverlay.classList.add('active');
                    
                    // Ganti teks loading sesuai keyword yang diketik
                    const keywordInput = form.querySelector('input[name="keyword"]').value;
                    const loadingMessage = loadingOverlay.querySelector('.loading-message');
                    if (keywordInput) {
                        loadingMessage.innerHTML = `Searching for '<strong>${keywordInput}</strong>'...`;
                    } else {
                         loadingMessage.innerHTML = `Searching certificates...`;
                    }
                });
            }
        });
    </script>
</body>

</html>