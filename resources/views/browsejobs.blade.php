<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Browse Jobs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- CSS Kustom yang Diperbarui --}}
    <style>
        /* CSS Sederhana untuk mencocokkan tema gelap dari template Anda */
        body {
            background-color: white;
            /* bg-dark */
            /* color: #f8f9fa; <-- DIHAPUS, konflik dengan bg white */
            /* text-white */
        }

        .card {
            background-color: #343a40;
            /* bg-secondary */
            border: none;
        }

        .card-title a {
            color: #172B4D !important;
            /* <-- DIUBAH ke warna baru */
            /* text-white */
            text-decoration: none;
        }

        .card-title a:hover {
            text-decoration: underline;
        }

        .text-white-decoration-none {
            color: #f8f9fa !important;
            text-decoration: none;
        }

        .text-white-decoration-none:hover {
            text-decoration: underline;
        }

        .footer {
            width: 100%;
            text-align: center;
            color: white;
            /* padding: 1rem 0; */
            margin-top: auto;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">
    {{-- 1. Menggunakan component header --}}
    <div style="background-color: #172B4D">
        @include('components.header')
    </div>


    <div class="container py-5">
        {{-- Judul halaman (DIUBAH dari text-black) --}}
        <h1 class="mb-4 fw-bold" style="color: #172B4D">Browse Jobs</h1>
        <h2>{{ $keywords }} : {{ $geoId }}</h2>
        <form action="{{ route('remind') }}", method="POST">
            @csrf
            <input type="text" name="keywords" value="{{ $keywords }}" hidden>
            <input type="text" name = "geoId" value="{{ $geoId }}" hidden>
            <button class="fw-bold text-black" type="submit">Remind Me</button>
        </form>
        {{-- 2. Memeriksa apakah $jobs ada dan merupakan array --}}
        @if (!empty($jobs) && (is_array($jobs) || $jobs instanceof \Illuminate\Support\Collection))

            {{-- 3. INTI PERUBAHAN (Grouping) --}}
            @foreach (collect($jobs)->groupBy('from') as $from => $jobList)
                {{-- Tampilkan nama grup (e.g., "LinkedIn", "Glints") --}}
                <h2 class="text-capitalize mt-4 mb-3" style="color: #172B4D">{{ $from }}</h2>

                {{-- Buat baris baru untuk kartu-kartu di grup ini --}}
                <div class="row g-3">

                    {{-- 4. Loop setiap pekerjaan ($job) di dalam grup ($jobList) --}}
                    @foreach ($jobList as $job)
                        <div class="col-md-6 col-lg-4">
                            {{-- Ini adalah template card asli Anda --}}
                            <div class="card h-100" style="background-color: #DAE1E9">

                                {{-- DIUBAH: text-white dihapus dari card-body --}}
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">
                                        @if (isset($job['jobUrl']))
                                            {{-- DIUBAH: class="text-black" dihapus, style dikontrol oleh CSS di <head> --}}
                                            <a href="{{ $job['jobUrl'] }}" target="_blank">
                                                {{ $job['jobTitle'] ?? '-' }}
                                            </a>
                                        @else
                                            {{ $job['jobTitle'] ?? '-' }}
                                        @endif
                                    </h5>

                                    <p class="mb-1">
                                        {{-- DIUBAH: class="text-black" menjadi inline style --}}
                                        <strong style="color: #172B4D">Company:</strong>
                                        @if (isset($job['companyUrl']) && $job['companyUrl'])
                                            {{-- DIUBAH: Memperbaiki class ganda dan menerapkan style baru --}}
                                            <a style="color: #172B4D; text-decoration: none;"
                                                href="{{ $job['companyUrl'] }}" target="_blank">
                                                {{ $job['companyName'] ?? '-' }}
                                            </a>
                                        @else
                                            {{ $job['companyName'] ?? '-' }}
                                        @endif
                                    </p>

                                    @if (!empty($job['location']))
                                        {{-- Teks ini sekarang terlihat karena 'text-white' dihapus dari parent --}}
                                        <p class="mb-1 text-dark"><strong>Location:</strong> {{ $job['location'] }}</p>
                                    @endif

                                    @if (!empty($job['postedTime']))
                                        {{-- Teks ini sekarang terlihat karena 'text-white' dihapus dari parent --}}
                                        <p class="mb-0 mt-auto pt-2 text-dark"><small>Posted:
                                                {{ $job['postedTime'] }}</small></p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        @else
            {{-- Pesan jika tidak ada pekerjaan ditemukan (DIUBAH dari text-black) --}}
            <p class="fw-bold" style="color: #172B4D">No jobs found.</p>
        @endif
    </div>

    {{-- 5. Menggunakan component footer --}}
    <footer class="footer">
        @include('components.footer')
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
