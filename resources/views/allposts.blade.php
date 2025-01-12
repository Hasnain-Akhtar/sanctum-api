<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>All Posts</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(45deg, #6a11cb, #2575fc);
      background-size: cover;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .container {
      background-color: #ffffff;
      border-radius: 15px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      padding: 30px;
      width: 100%;
      max-width: 1200px;
    }

    .card {
      border-radius: 15px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      margin-bottom: 20px;
    }

    .card-title {
      font-weight: bold;
      font-size: 24px;
      color: #333;
    }

    .d-flex {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .btn-action {
      margin-right: 10px;
    }

    .logout-btn {
      background-color: #dc3545;
      border-color: #dc3545;
      color: #ffffff;
      font-weight: bold;
    }

    .logout-btn:hover {
      background-color: #c82333;
    }

    .post-image {
      max-height: 100px;
      object-fit: cover;
      border-radius: 8px;
    }

    @media (max-width: 992px) {
      .container {
        padding: 20px;
        width: 90%;
      }

      .card-title {
        font-size: 20px;
      }
    }

    @media (max-width: 768px) {
      .container {
        padding: 15px;
        width: 100%;
      }

      .card-title {
        font-size: 18px;
      }

      .post-image {
        max-height: 80px;
      }
    }

    @media (max-width: 576px) {
      .container {
        padding: 10px;
      }

      .card-title {
        font-size: 16px;
      }

      .logout-btn {
        width: 100%;
        margin-top: 10px;
      }

      .post-image {
        max-height: 60px;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="d-flex justify-content-between align-items-center">
      <div class="text-center ">
        <a href="/addpost" class="btn btn-success">Create New Post</a>
      </div>
      <div class="align-items-center mt-8 mb-2">
        <h3 class="card-title pt-5 ">All Posts</h3>
      </div>
      <button type="button" class="btn logout-btn" id="logoutBtn">Logout</button>
    </div>

    <div id="postsContainer">
      <!-- Posts will be dynamically loaded here -->
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script>
    $(document).ready(function () {
      // Redirect to update page
      window.updatePost = function(postId) {
        window.location.href = `/updatepost?id=${postId}`; // Pass postId in URL
      }

      // Redirect to view page
      window.viewPost = function(postId) {
        window.location.href = `/viewpost?id=${postId}`; // Pass postId in URL
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
          <div class="row">
            <div class="col-12 col-md-3 font-weight-bold border-right border-bottom bg-dark text-white p-2">Title</div>
            <div class="col-12 col-md-3 font-weight-bold border-right border-bottom bg-dark text-white p-2">Description</div>
            <div class="col-12 col-md-3 font-weight-bold border-right border-bottom bg-dark text-white p-2">Image</div>
            <div class="col-12 col-md-3 font-weight-bold text-center border-bottom bg-dark text-white p-2">Actions</div>
          </div>
        `;
        
        posts.forEach(post => {
          postsHTML += `
            <div class="row">
              <div class="col-12 col-md-3 border p-2">
                <h5>${post.title}</h5>
              </div>
              <div class="col-12 col-md-3 border p-2">
                <p>${post.description}</p>
              </div>
              <div class="col-12 col-md-3 border p-2">
                <img src="/uploads/${post.image}" alt="${post.title}" class="img-fluid post-image">
              </div>
              <div class="col-12 col-md-3 text-center border p-2">
                <div class="d-flex justify-content-around">
                  <button class="btn btn-outline-info btn-sm" onclick="viewPost('${post.id}')">View</button>
                  <button class="btn btn-outline-warning btn-sm" onclick="updatePost('${post.id}')">Update</button>
                  <button class="btn btn-outline-danger btn-sm" onclick="deletePost('${post.id}')">Delete</button>
                </div>
              </div>
            </div>
          `;
        });

        $('#postsContainer').html(postsHTML);
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
</body>
</html>
