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
            <a class="text-white text-decoration-none" data-bs-toggle="collapse" href="#browseForm" role="button"
                aria-expanded="false" aria-controls="browseForm">
                Browse Jobs
            </a>
        </p>
        <p class="fw-bold mb-0">About</p>
    </div>

    <!-- Circle icon -->
    <div>
        <div class="rounded-circle"
            style="width: 50px; height: 50px; background-color: transparent; border: 5px solid white;">
        </div>
    </div>
</header>

<!-- Collapse form di luar header -->
<div class="collapse position-fixed top-0 start-0 w-100 h-100" id="browseForm" style="z-index:2000;">
    <div class="d-flex justify-content-center align-items-start pt-5 w-100 h-100"
        style="background-color: rgba(0,0,0,0.5); backdrop-filter: blur(5px);">

        <form action="{{ route('job.find') }}" method="POST" class="p-4 position-relative"
            style="background-color:#172B4D; border-radius:10px; width:300px;">
            @csrf
            <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-2"
                aria-label="Close" data-bs-toggle="collapse" data-bs-target="#browseForm">
            </button>

            <div class="mb-3">
                <label for="keyword" class="form-label text-white">Keywords</label>
                <input type="text" name="keywords" class="form-control" id="keywords" placeholder="Enter keyword">
            </div>
            <div class="mb-3">
                <label for="geoId" class="form-label text-white">Geo ID</label>
                <input type="text" name="geoId" class="form-control" id="geoId" placeholder="Enter Geo ID">
            </div>
            <button type="submit" class="btn btn-primary w-100">Search</button>
        </form>

    </div>
</div>
