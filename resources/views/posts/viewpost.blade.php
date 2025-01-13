@extends('layouts.app')

@section('title', 'View Post')

@section('content')
<section class="flex justify-center items-center min-h-screen bg-gray-50">
  <div class="container mx-auto px-5 py-24 flex justify-center">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden lg:w-2/3 md:w-3/4 w-5/6">
      <!-- Dynamic Post Image -->
      <img id="postImage" class="w-full h-64 object-cover object-center" alt="Post Image" src="" />
      <div class="p-6">
        <!-- Post Title -->
        <h1 class="title-font sm:text-4xl text-3xl mb-4 font-medium text-gray-900" id="postTitleCell">Post Title</h1>
        <!-- Post Description -->
        <p class="mb-8 leading-relaxed" id="postDescriptionCell">Post Description</p>
        <div class="flex justify-center">
          <a href="/allposts" class="inline-flex text-white bg-indigo-600 border-0 py-3 px-8 focus:outline-none hover:bg-indigo-700 rounded-lg text-lg shadow-md transition duration-300 ease-in-out transform hover:scale-105">
            Back to All Posts
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        // Get the post ID from the URL
        const urlParams = new URLSearchParams(window.location.search);
        const postId = urlParams.get('id');

        // Fetch the post details
        $.ajax({
            url: `/api/posts/${postId}`,
            type: 'GET',
            headers: {
                Authorization: `Bearer ${localStorage.getItem('token')}`
            },
            success: function(response) {
                if (response.success === true) {
                    const post = response.data;
                    $('#postTitleCell').text(post.title);
                    $('#postDescriptionCell').text(post.description);
                    $('#postImage').attr('src', `/uploads/${post.image}`);
                } else {
                    alert('Post not found!');
                }
            },
            error: function() {
                alert('An error occurred while fetching the post.');
            }
        });
    });
</script>

<style>
    /* Styling for the post image */
/* Styling for the post image */
#postImage {
    height: 70vh; /* Set the height to 30% of the viewport height */
    width: 100%; /* Make the image width 100% of its container */
    object-fit: cover; /* Ensure the image covers the area without distortion */
    border-bottom-left-radius: 0;
    border-bottom-right-radius: 0;
}

/* Card container should adjust based on image size */
.bg-white {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: auto; /* Allow the card to adjust its height based on content */
}

/* Button Styling */
.btn-back {
    background-color: #4C51BF;
    color: white;
    font-weight: bold;
    border-radius: 10px;
    padding: 12px 24px;
    text-decoration: none;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: background-color 0.3s ease, transform 0.3s ease;
}

.btn-back:hover {
    background-color: #434190;
    transform: scale(1.05);
}

/* Media Queries for Responsiveness */
@media (max-width: 768px) {
    .container {
        padding: 20px;
    }

    .title-font {
        font-size: 2rem;
    }

    .btn-back {
        padding: 10px 20px;
    }
}

</style>
@endsection

