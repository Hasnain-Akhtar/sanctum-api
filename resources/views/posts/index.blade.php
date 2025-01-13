@extends('layouts.app')

@section('title', 'All Posts')

@push('styles')
<style>
    .post-card {
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        margin-bottom: 20px;
    }

    .post-image {
        max-height: 100px;
        object-fit: cover;
        border-radius: 8px;
    }

    @media (max-width: 992px) {
        .post-image {
            max-height: 80px;
        }
    }

    @media (max-width: 576px) {
        .post-image {
            max-height: 60px;
        }
    }
</style>
@endpush

@section('content')
<div class="container py-12 mx-auto flex flex-wrap md:flex-nowrap items-center justify-between">
    <div class="d-flex justify-content-between align-items-center">
    <h1 style="font-size: 2rem; font-weight: bold;">All Posts</h1>
</div>
<div class="d-flex justify-content-start">
    <a href="/posts/createpost" class="btn btn-success mt-3">Create New Post</a>
</div>
<div class="text-center">
    <a href="/login" class="btn btn-danger">Logout</a>
</div>

    <!-- Loading State with Shimmer Effect -->
    <div id="loadingContent" class="shimmer-container">
        <div class="shimmer-text w-32 h-6 mb-4"></div> <!-- Shimmering text -->
        <div class="shimmer-text w-40 h-6 mb-4"></div> <!-- Shimmering text -->
        <div class="shimmer-img w-full h-64 mb-4"></div> <!-- Shimmering image -->
    </div>

    <!-- Actual Content -->
    <div id="actualContent" class="hidden">
        <div id="postsContainer">
            <!-- Dynamic posts will be loaded here -->
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
  $(document).ready(function () {
    // Redirect to update page
    window.updatePost = function(postId) {
      window.location.href = `/posts/updatepost?id=${postId}`; // Pass postId in URL
    }

    // Redirect to view page
    window.viewPost = function(postId) {
      window.location.href = `/posts/viewpost?id=${postId}`; // Pass postId in URL
    }

    // Handle logout
    $('#logoutBtn').click(function () {
      if (confirm('Are you sure you want to logout?')) {
        $.ajax({
          url: '/api/logout', // Your API endpoint for logout
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

    // Fetch posts and display them
    function fetchPosts() {
      $.ajax({
        url: '/api/posts',
        type: 'GET',
        headers: {
          Authorization: `Bearer ${localStorage.getItem('token')}`
        },
        success: function (response) {
          if (response.success === true) {
            displayPosts(response.data.posts); // Pass posts from response
          } else {
            alert('No posts found!');
          }
        },
        error: function () {
          alert('An error occurred while fetching posts.');
        }
      });
    }

    // Display posts in a responsive grid format
    function displayPosts(posts) {
  let postsHTML = `
    <section class="text-gray-600 body-font">
      <div class="container py-12 mx-auto">
        <div class="flex flex-wrap -m-4">
  `;

  // Display the first 3 posts in grid format
  posts.slice(0, 3).forEach(post => {
    const description = post.description.length > 50 ? `${post.description.slice(0, 50)}...` : post.description;
    postsHTML += `
      <div class="p-2 md:w-1/3">
        <div class="h-full border-2 border-gray-200 border-opacity-60 rounded-lg overflow-hidden">
          <img class="lg:h-48 md:h-36 w-full object-cover object-center transition-transform duration-300 transform hover:scale-105" src="/uploads/${post.image}" alt="${post.title}">
          <div class="p-6">
            <h1 class="title-font text-lg font-medium text-gray-900 mb-3">${post.title}</h1>
            <p class="leading-relaxed mb-3">${description}</p>
            <div class="flex items-center flex-wrap">
              <button class="text-indigo-500 inline-flex items-center md:mb-2 lg:mb-0" onclick="viewPost('${post.id}')">Learn More
                <svg class="w-4 h-4 ml-2" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M5 12h14"></path>
                  <path d="M12 5l7 7-7 7"></path>
                </svg>
              </button>
              <button class="text-yellow-500 ml-4 inline-flex items-center md:mb-2 lg:mb-0" onclick="updatePost('${post.id}')">Update</button>
              <button class="text-red-500 ml-4 inline-flex items-center md:mb-2 lg:mb-0" onclick="deletePost('${post.id}')">Delete</button>
            </div>
          </div>
        </div>
      </div>
    `;
  });

  // Display the next 6 posts in list format
  if (posts.length > 3) {
    postsHTML += `
      <div class="pt-8 bg-white py-8 px-4">
        <h3 class="text-xl font-medium text-gray-900 mb-4">More Posts</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
    `;
    posts.slice(3, 9).forEach(post => {
      postsHTML += `
        <div class="relative py-3 px-3 bg-white border border-gray-300 rounded-lg shadow-sm hover:shadow-xl hover:scale-105 transition-all duration-300 ease-in-out transform max-h-[280px]">
          <div class="flex justify-between gap-x-4">
            <div class="flex min-w-0 gap-x-3">
              <img alt="" src="/uploads/${post.image}" class="size-12 flex-none rounded-full bg-gray-50 w-10 h-10 object-cover" />
              <div class="min-w-0 flex-auto">
                <p class="text-sm font-semibold text-gray-900">${post.title}</p>
                <p class="mt-1 truncate text-xs text-gray-500">${post.description}</p>
                <div class="flex flex-wrap mt-3">
                  <button class="text-indigo-500 inline-flex items-center mr-3 hover:text-indigo-600" onclick="viewPost('${post.id}')">Learn More
                    <svg class="w-4 h-4 ml-2" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M5 12h14"></path>
                      <path d="M12 5l7 7-7 7"></path>
                    </svg>
                  </button>
                  <button class="text-yellow-500 inline-flex items-center mr-3 hover:text-yellow-600" onclick="updatePost('${post.id}')">Update</button>
                  <button class="text-red-500 inline-flex items-center hover:text-red-600" onclick="deletePost('${post.id}')">Delete</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      `;
    });
    postsHTML += `</div></div>`;
  }

  // Apply special style for the 10th image
  if (posts.length > 9) {
  const post = posts[9];
  postsHTML += `
    <!-- Section for Videos -->
    <section class="text-gray-600 body-font bg-black border-white border-2 rounded-lg shadow-lg w-full ">
      <div class="container py-16 mx-auto px-6">
        <h2 class="text-3xl font-semibold text-white mb-8 text-center">Live Videos</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 px-6">
          <!-- Main YouTube Video -->
          <div class="col-span-2">
            <iframe class="w-full h-96 rounded-lg shadow-lg" src="https://www.youtube.com/embed/WhYrPMVgqxk?si=B_ck2yTIkRJTSos9" frameborder="0" allowfullscreen></iframe>
          </div>
          <!-- Additional Videos -->
          <div class="col-span-1 flex flex-col gap-4">
            <div class="rounded-lg shadow-lg overflow-hidden">
              <iframe class="w-full h-44" src="https://www.youtube.com/embed/WhYrPMVgqxk?si=B_ck2yTIkRJTSos9" frameborder="0" allowfullscreen></iframe>
            </div>
            <div class="rounded-lg shadow-lg overflow-hidden">
              <iframe class="w-full h-44" src="https://www.youtube.com/embed/WhYrPMVgqxk?si=B_ck2yTIkRJTSos9" frameborder="0" allowfullscreen></iframe>
            </div>
          </div>
        </div>
      </div>
    </section>

<section class="text-gray-600 body-font bg-gradient-to-r from-gray-800 via-gray-900 to-black border-white border-2 rounded-lg shadow-xl mt-12 transform hover:scale-105 transition duration-500 ease-in-out">
  <div class="container py-16 mx-auto">
    <h2 class="text-3xl font-semibold text-white mb-8 text-center uppercase tracking-wider">Spotlight Post</h2>
    <div class="lg:w-4/6 mx-auto">
      <!-- Auto-Moving Image Carousel -->
      <div class="relative overflow-hidden rounded-lg mb-6">
        <div class="flex w-max animate-scroll space-x-4">
          <img alt="Post Image" class="object-cover object-center h-72 w-96 rounded-lg shadow-lg transform hover:scale-105 transition duration-300 ease-in-out" src="/uploads/${post.image}">
          <img alt="Post Image 2" class="object-cover object-center h-72 w-96 rounded-lg shadow-lg transform hover:scale-105 transition duration-300 ease-in-out" src="/uploads/${post.image}">
          <img alt="Post Image 3" class="object-cover object-center h-72 w-96 rounded-lg shadow-lg transform hover:scale-105 transition duration-300 ease-in-out" src="/uploads/${post.image}">
          <img alt="Post Image 4" class="object-cover object-center h-72 w-96 rounded-lg shadow-lg transform hover:scale-105 transition duration-300 ease-in-out" src="/uploads/${post.image}">
          <img alt="Post Image 5" class="object-cover object-center h-72 w-96 rounded-lg shadow-lg transform hover:scale-105 transition duration-300 ease-in-out" src="/uploads/${post.image}">
        </div>
      </div>
      
      <!-- Post Details -->
      <div class="flex flex-col sm:flex-row items-center border-white border-2 rounded-lg shadow-xl p-8 bg-gradient-to-r from-gray-800 via-gray-900 to-black transform hover:scale-105 transition duration-500 ease-in-out">
        <!-- Author Avatar -->
        <div class="sm:w-1/3 text-center sm:pr-8 sm:py-8">
          <div class="w-20 h-20 rounded-full inline-flex items-center justify-center bg-gray-200 text-gray-400 shadow-lg">
            <img src="https://dummyimage.com/100x100" class="w-full h-full rounded-full" alt="Author">
          </div>
          <h3 class="text-lg text-white font-medium mt-4">${post.author || 'Author Name'}</h3>
          <div class="w-12 h-1 bg-indigo-500 rounded mt-2 mb-4"></div>
        </div>
        
        <!-- Post Description -->
        <div class="sm:w-2/3 sm:pl-8 sm:py-8 sm:border-l border-white">
          <p class="leading-relaxed text-lg text-gray-300 mb-4">${post.description}</p>
          <a class="text-indigo-500 inline-flex items-center font-medium hover:text-indigo-400 transition duration-300 ease-in-out" onclick="viewPost('${post.id}')">Learn More
            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4 ml-2" viewBox="0 0 24 24">
              <path d="M5 12h14M12 5l7 7-7 7"></path>
            </svg>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>


    <style>
      /* Scrolling Animation */
      @keyframes scroll {
        0% {
          transform: translateX(0);
        }
        100% {
          transform: translateX(-100%);
        }
      }

      .animate-scroll {
        animation: scroll 20s linear infinite;
      }
    </style>
  `;
}


  postsHTML += `
        </div>
      </div>
    </section>
  `;

  $('#postsContainer').html(postsHTML);
  document.getElementById('loadingContent').classList.add('hidden');
  document.getElementById('actualContent').classList.remove('hidden');
}


    // Delete post
    window.deletePost = function(postId) {
      if (confirm('Are you sure you want to delete this post?')) {
        $.ajax({
          url: `/api/posts/${postId}`,
          type: 'DELETE',  // Use 'DELETE' method
          headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`  // Pass token in headers
          },
          success: function(response) {
            if (response.success === true) {
              alert('Post deleted successfully!');
              fetchPosts(); // Refresh posts list
            } else {
              alert('Error deleting post!');
            }
          },
          error: function() {
            alert('An error occurred while deleting the post.');
          }
        });
      }
    }

    fetchPosts(); // Fetch posts on page load
  });
</script>
@endpush
