<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
    <!-- Bootstrap CSS for styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Apply gradient background */
        body {
            background: linear-gradient(45deg, #6a11cb, #2575fc);
            background-size: cover;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            max-width: 600px;
            margin: 50px auto;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 30px;
            background-color: #ffffff;
            border-radius: 10px;
        }

        .card-title {
            font-weight: bold;
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .btn-block {
            width: 100%;
        }

        @media (max-width: 576px) {
            .card {
                width: 90%;
            }

            .card-title {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Create Post Form -->
    <div class="card">
        <div class="card-body">
            <h5 class="card-title text-center">Create Post</h5>
            <form id="createPostForm">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" id="title" placeholder="Enter post title" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" rows="3" placeholder="Enter post description" required></textarea>
                </div>
                <div class="form-group">
                    <label for="image">Image</label>
                    <input type="file" class="form-control" id="image" accept="image/*" required>
                </div>
                <button type="submit" class="btn btn-primary w-100 mt-3">Create Post</button>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // Handle form submission
        document.getElementById('createPostForm').addEventListener('submit', function (event) {
            event.preventDefault();

            // Get form data
            const title = document.getElementById('title').value;
            const description = document.getElementById('description').value;
            const image = document.getElementById('image').files[0];

            // Prepare FormData for API submission
            const formData = new FormData();
            formData.append('title', title);
            formData.append('description', description);
            formData.append('image', image);

            // Get the JWT token from localStorage or sessionStorage
            const token = localStorage.getItem('token'); // Replace with actual token retrieval logic

            // Make the API request using jQuery
            $.ajax({
                url: '/api/posts', // Your API endpoint
                type: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                headers: {
                    'Authorization': `Bearer ${token}`  // Add the JWT token to the header
                },
                success: function (data) {
                    if (data.success) {
                        alert('Post created successfully!');
                        window.location.href = '/allposts'; // Redirect to the main all posts page
                    } else {
                        alert('Error creating post: ' + data.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error:', error);
                    alert('An error occurred while creating the post.');
                }
            });
        });
    </script>
</body>
</html>
