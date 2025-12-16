<header class="p-4 bg-gray-800 text-white d-flex justify-content-between align-items-center">
    <!-- Logo -->
    <div>
        <img src="./images/HiredHubLogo.png" style="height: 50px; width: 80px">
    </div>

    <!-- Menu -->
    <div class="d-flex flex-row gap-4 align-items-center">
        <p class="fw-bold mb-0">
            <a class="text-white text-decoration-none" href="/home" role="button">
                Home
            </a>
        </p>
        <p class="fw-bold mb-0">
            <a class="text-white text-decoration-none" 
               href="#" 
               role="button"
               data-bs-toggle="collapse" 
               data-bs-target="#browseForm" 
               aria-expanded="false" 
               aria-controls="browseForm">
                Browse Jobs
            </a>
        </p>
        <p class="fw-bold mb-0">
    <a class="text-white text-decoration-none" href="{{ route('certificate.index') }}" role="button">
        Certificate
    </a>
</p>
        <p class="fw-bold mb-0">
            <a class="text-white text-decoration-none" href="{{ route('about') }}" role="button">
                About
            </a>
        </p>
    </div>

    <!-- Circle icon -->
    <div class="dropdown">
        <a class="dropdown-toggle p-0" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"
            style="text-decoration: none;">
            <div class="rounded-circle"
                style="width: 50px; height: 50px; background-color: white; border: 5px solid white; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                <img src="{{ asset('images/profile.png') }}" alt="Profile Picture"
                    style="width: 100%; height: 100%; object-fit: cover;">
            </div>
        </a>

        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-2"
            style="border-radius: 10px; min-width: 200px;">

            <li>
                <a class="dropdown-item d-flex align-items-center" href="{{ route('see.reminder') }}">
                    <i class="fa-solid fa-bell me-2" style="color: #172B4D;"></i>
                    Job Reminders
                </a>
            </li>

            <li>
                <hr class="dropdown-divider">
            </li>

            <li>
                <form id="login-form" action="{{ route('login') }}" method="GET" style="display: none;">
                    @csrf
                </form>
                <a class="dropdown-item d-flex align-items-center text-primary" href="{{ route('login') }}"
                    onclick="event.preventDefault(); document.getElementById('login-form').submit();">
                    <i class="fa-solid fa-right-from-bracket me-2"></i>
                    Login
                </a>
            </li>
        </ul>
    </div>
</header>


<!-- Collapse form di luar header -->
<div class="collapse position-fixed top-0 start-0 w-100 h-100" id="browseForm" style="z-index:2000;">
    <div class="d-flex justify-content-center align-items-start pt-5 w-100 h-100"
        style="background-color: rgba(0,0,0,0.5); backdrop-filter: blur(5px);">

        <form action="{{ route('job') }}" method="POST" enctype="multipart/form-data"
            class="p-4 position-relative" style="background-color:#172B4D; border-radius:10px; width:300px;">
            @csrf
            <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-2"
                aria-label="Close" data-bs-toggle="collapse" data-bs-target="#browseForm">
            </button>

            <div class="mb-3">
                <label for="keywords" class="form-label text-white">Keywords</label>
                <input type="text" name="keywords" class="form-control" id="keywords" placeholder="Enter keyword">
            </div>

            <div class="mb-3">
                <label for="geoId" class="form-label text-white">Geo ID</label>
                <input type="text" name="geoId" class="form-control" id="geoId" placeholder="Enter Geo ID">
            </div>

            <!--  Upload PDF -->
            <div class="mb-3">
                <div class="d-flex flex-row align-items-center">
                    <label for="cvFile" class="form-label text-white">Upload CV (PDF)</label>
                    <img class="ms-2 mb-2" style="width : 30px" src="{{ asset('images/AI.png') }}" alt="AI">
                </div>

                <input type="file" name="file" class="form-control" id="cvFile" accept="application/pdf">
            </div>

            <button type="submit" class="btn btn-primary w-100">Search</button>
        </form>

    </div>
</div>

