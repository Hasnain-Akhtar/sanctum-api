<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
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

        .img-preview {
            max-width: 100%;
            margin-top: 10px;
            border-radius: 8px;
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
    <div class="card">
        <div class="card-body">
            <h5 class="card-title text-center">Update Post</h5>
            <form id="updatePostForm">
                <input type="hidden" id="postId" value=""> <!-- Hidden field for post ID -->
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                </div>
                <div class="form-group">
                    <label for="image">Image</label>
                    <input type="file" class="form-control" id="image">
                    <img id="imagePreview" class="img-preview" src="" alt="Current Image Preview" style="display: none;">
                </div>
                <button type="submit" class="btn btn-primary btn-block">Update Post</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
$(document).ready(function () {
    // Fetch post details for update
    const postId = new URLSearchParams(window.location.search).get('id');
    $.ajax({
        url: `/api/posts/${postId}`,
        type: 'GET',
        headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`
        },
        success: function (response) {
            if (response.success === true) {
                $('#postId').val(response.data.id);
                $('#title').val(response.data.title);
                $('#description').val(response.data.description);

                // Show the current image if it exists
                if (response.data.image) {
                    $('#imagePreview').attr('src', `/uploads/${response.data.image}`).show();
                }
            } else {
                alert('Post not found!');
            }
        },
        error: function () {
            alert('An error occurred while fetching post details.');
        }
    });

    // Handle form submission to update post
    $('#updatePostForm').submit(function (e) {
    e.preventDefault();

    const title = $('#title').val();
    const description = $('#description').val();
    const imageFile = $('#image')[0].files[0];
    const formData = new FormData();
    formData.append('title', title);
    formData.append('description', description);

    // Add the `_method` field to indicate a PUT request
    formData.append('_method', 'PUT');

    // Only append the image if a new one is selected
    if (imageFile) {
        formData.append('image', imageFile);
    }

    // Log the form data for debugging
    formData.forEach((value, key) => {
        console.log(key + ": " + value);
    });

    $.ajax({
        url: `/api/posts/${$('#postId').val()}`,  // Ensure this URL matches your route
        type: 'POST',  // Use POST because we're simulating PUT with `_method`
        headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`
        },
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            console.log(response);  // Log the full response for debugging
            if (response.success === true) {
                alert('Post updated successfully!');
                $('#title').val(response.data.title);
                $('#description').val(response.data.description);
                if (response.data.image) {
                    $('#imagePreview').attr('src', `/uploads/${response.data.image}`).show();
                }
                window.location.href = '/allposts';  // Redirect after successful update
            } else {
                alert('Failed to update post!');
            }
        },
        error: function (xhr) {
            console.error('Error:', xhr.responseText);
            alert('An error occurred while updating the post.');
        }
    });
});


        });

    </script>
</body>
</html>
