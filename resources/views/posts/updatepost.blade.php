@extends('layouts.app')

@section('title', 'Update Post')

@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <h2 style="padding-bottom: 1rem; font-weight: bold;">Update Post</h2>
                <form id="updatePostForm">
                    <input type="hidden" id="postId" value=""> <!-- Hidden field for post ID -->
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" class="form-control" id="image">
                        <img id="imagePreview" class="img-preview" src="" alt="Current Image Preview" style="display: none; margin-top: 10px;">
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary w-50 mt-3">Update Post</button>
                    </div>
                </form>
            </div>
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

    <style>
        /* Apply plain background */
        body {
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .main-content {
            flex-grow: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            max-width: 600px;
            margin: 40px auto;
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
@endsection
