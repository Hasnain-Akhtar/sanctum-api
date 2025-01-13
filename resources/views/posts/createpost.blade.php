@extends('layouts.app')

@section('title', 'Create Post')

@section('content')
<div class="card">
    <div class="card-body">
        <h2 style="padding-bottom: 1rem; font-weight: bold;">Create Post</h2>
        <form method="POST" action="/posts" enctype="multipart/form-data" id="createPostForm">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Enter post title" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter post description" required></textarea>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
            </div>
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-primary w-50 mt-3">Create Post</button>
            </div>
        </form>
    </div>
</div>

<!-- Bootstrap and jQuery -->
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

