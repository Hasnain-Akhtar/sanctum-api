<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-3">
    <div class="container-fluid container py-12 mx-auto flex flex-wrap md:flex-nowrap items-center justify-between">
        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center" href="#">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-10 h-10 text-white p-2 bg-indigo-500 rounded-full me-2" viewBox="0 0 24 24">
                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path>
            </svg>
            <span class="ms-2 text-xl text-white">My-News-Website</span>
        </a>
        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Navbar Links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="/allposts">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/posts/createpost">Create Post</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/posts/contact">ContactUs</a>
                </li>
            </ul>
            <!-- Search Form -->
            <form class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>
    </div>
</nav>
