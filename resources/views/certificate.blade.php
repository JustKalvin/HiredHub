<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Montserrat:wght@400;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        /* FONT PENTING */
        body {
            /* 1. SEMUA TEKS default-nya adalah Inter */
            font-family: 'Inter', sans-serif !important; 
            background-color: white;
            color: #172B4D; /* Warna teks default */
        }

        h1, h2, h3, h4, h5, h6, .font-montserrat {
            /* 2. JUDUL/HEADER/ELEMEN PENTING adalah Montserrat */
            font-family: 'Montserrat', sans-serif !important;
            font-weight: 700;
        }
        
        /* 3. TEXT SHADOW (Untuk Judul di Halaman Lain) */
        .text-shadow-custom {
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.5);
        }
        
        /* --- STYLE KHUSUS HALAMAN CERTIFICATE --- */
        .card {
            background-color: #DAE1E9;
            border: none;
        }

        /* Kita tambahkan font Montserrat ke card title link agar konsisten */
        .card-title a {
            color: #172B4D;
            text-decoration: none;
            font-family: 'Montserrat', sans-serif !important; /* Paksa Montserrat */
        }

        .card-title a:hover {
            text-decoration: underline;
        }

        /* Kita tambahkan font Montserrat ke section title agar konsisten */
        .section-title {
            color: #172B4D;
            font-weight: bold;
            font-family: 'Montserrat', sans-serif !important; /* Paksa Montserrat */
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">
    <x-chatbot />
    <div style="background-color: #172B4D">
        @include('components.header')
    </div>
    <div class="container py-5">

        <h1 class="mb-4 fw-bold section-title">Find Certificate</h1>

        <form action="{{ route('certificate.find') }}" method="POST" class="mb-4">
            @csrf
            <div class="d-flex gap-2">
                <input name="keyword" type="text" class="form-control" placeholder="Search certificate">
                <button class="btn btn-dark fw-bold" type="submit">Search</button>
            </div>
        </form>

        @if (!empty($results))
            <h2 class="section-title mt-4 mb-3">Results for {{ $keyword }}</h2>

            <div class="row g-3">
                @foreach ($results as $item)
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-lg border-0 rounded-4 p-3" style="background-color: #ffffff">

                            <div class="d-flex align-items-start gap-3">
                                <div class="rounded-circle d-flex justify-content-center align-items-center"
                                    style="width: 48px; height: 48px; background-color: #172B4D; color: white; font-weight: bold;">
                                    {{ isset($item['name']) ? strtoupper(substr($item['name'], 0, 1)) : '?' }}
                                </div>

                                <div class="flex-grow-1">
                                    <h5 class="card-title mb-1" style="font-size: 1.1rem;">
                                        <a href="{{ $item['url'] ?? '#' }}" target="_blank"
                                            style="color: #172B4D; text-decoration: none;">
                                            {{ $item['name'] ?? 'Unknown' }}
                                        </a>
                                    </h5>

                                    <a href="{{ $item['url'] }}" target="_blank" class="btn fw-bold w-100"
                                        style="background-color: #172b4d; color: white; border-radius: 10px;">
                                        Open Certificate
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        @if (empty($results))
            <p class="fw-bold section-title">No certificate found.</p>
        @endif

    </div>
    <x-footer />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
