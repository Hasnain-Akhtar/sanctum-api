<nav class="navbar navbar-expand-lg navbar-dark bg-dark ">
    <div class="container-fluid container mx-auto flex flex-wrap md:flex-nowrap items-center justify-between">
        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center" href="#">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-10 h-10 text-white p-2 bg-indigo-500 rounded-full me-2" viewBox="0 0 24 24">
                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path>
                <a class="ms-2 text-xl text-white" href="/admin/allposts">My-Admin-Website</a>
            </svg>
        </a>
        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Navbar Links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="/admin/allposts">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/posts/createpost">Create Post</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/posts/live-videos">Live Videos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/posts/spotlight-posts">SpotLight Posts</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/posts/editors_quotes">Editors</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/posts/contact">ContactUs</a>
                </li>
            </ul>
            <!-- Search Form -->
            <form class="d-flex ">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
            <div class="text-center ml-2">
                <a href="javascript:void(0);" id="logoutBtn" class="bg-red-600 text-white py-2 px-2 rounded-lg shadow-lg hover:bg-red-700 transition duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 w-full md:w-auto text-lg">Logout</a>
            </div>
            
            @push('scripts')
            <!-- Load jQuery first -->
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
          
            <!-- Your other scripts -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
          
            <script>
              $(document).ready(function () {
                $('#logoutBtn').click(function () {
                  if (confirm('Are you sure you want to logout?')) {
                    $.ajax({
                      url: '/api/admin/logout', // Your API endpoint for logout
                      type: 'POST',
                      headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}` // Pass token in headers
                      },
                      success: function (response) {
                        if (response.status === true) {
                          alert('Logout successful!');
                          localStorage.removeItem('token'); // Remove token from localStorage
                          window.location.href = '/'; // Redirect to login page
                        } else {
                          alert('Logout failed!');
                        }
                      },
                      error: function (error) {
                        alert('An error occurred while logging out.');
                      }
                    });
                  }
                });
              });
            </script>
          @endpush
            
        </div>
    </div>
</nav>
