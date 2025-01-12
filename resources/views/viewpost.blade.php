<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>View Post</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(45deg, #6a11cb, #2575fc);
      background-size: cover;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: 'Arial', sans-serif;
    }

    .container {
      background-color: #ffffff;
      border-radius: 15px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      padding: 30px;
      width: 100%;
      max-width: 900px;
      margin-top: 50px;
    }

    .card-title {
      font-weight: bold;
      font-size: 28px;
      color: #333;
      margin-bottom: 20px;
      text-align: center;
    }

    .table th, .table td {
      padding: 12px;
      text-align: left;
    }

    .table th {
      background-color: #3b3a3b;
      color: white;
    }

    .post-image {
      max-width: 100%;
      height: auto;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .btn-back {
      background-color: #2575fc;
      color: white;
      font-weight: bold;
      border-radius: 10px;
      padding: 10px 20px;
      text-decoration: none;
    }

    .btn-back:hover {
      background-color: #343435;
    }

    .post-details {
      margin-top: 30px;
    }

    @media (max-width: 768px) {
      .container {
        padding: 20px;
        width: 90%;
      }

      .card-title {
        font-size: 24px;
      }

      .table th, .table td {
        padding: 10px;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <h3 class="card-title" id="postTitle">Post Title</h3>

    <div class="post-details">
      <table class="table table-bordered">
        <tr>
          <th>Title</th>
          <td id="postTitleCell"></td>
        </tr>
        <tr>
          <th>Description</th>
          <td id="postDescriptionCell"></td>
        </tr>
        <tr>
          <th>Image</th>
          <td>
            <img id="postImage" src="" alt="Post Image" class="post-image">
          </td>
        </tr>
      </table>

      <div class="mt-4 text-center">
        <a href="/allposts" class="btn btn-back">Back to All Posts</a>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
</body>
</html>
