<?php

namespace App\Http\Controllers\API;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\BaseController as BaseController;

class PostController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'posts' => Post::all()
        ];

        return $this->sendResponse($data, 'All posts');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'title' => 'string|max:255',
            'description' => 'string',
            'image' => 'mimes:png,jpeg,gif|max:2048', // Increased max file size to 2MB
        ]);

        // If validation fails, return an error response
        if ($validator->fails()) {
            return $this->sendError('Invalid request data', $validator->errors()->all());
        }

        // Check if the image is present in the request
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $ext = $image->getClientOriginalExtension();
            $imageName = time() . '.' . $ext;

            // Ensure the 'uploads' directory exists and is writable
            $uploadPath = public_path('uploads');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // Move the uploaded image to the 'uploads' directory
            $image->move($uploadPath, $imageName);
        }

        // Create the post record in the database
        $post = Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => isset($imageName) ? $imageName : null,
        ]);

        return $this->sendResponse($post, 'Post created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return $this->sendError('Post not found');
        }

        return $this->sendResponse($post, 'Post details');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|mimes:png,jpeg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Invalid request data', $validator->errors()->all());
        }

        $post = Post::find($id);
        if (!$post) {
            return $this->sendError('Post not found');
        }

        // Check if a new image is uploaded
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $ext = $image->getClientOriginalExtension();
            $imageName = time() . '.' . $ext;

            // Ensure the 'uploads' directory exists and is writable
            $uploadPath = public_path('uploads');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // Move the uploaded image to the 'uploads' directory
            $image->move($uploadPath, $imageName);

            // Delete old image if it exists
            if ($post->image && file_exists(public_path('uploads/' . $post->image))) {
                unlink(public_path('uploads/' . $post->image));
            }

            $post->image = $imageName;
        }

        $post->title = $request->title;
        $post->description = $request->description;
        $post->save();

        return $this->sendResponse($post, 'Post updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return $this->sendError('Post not found');
        }

        // Delete image if it exists
        if ($post->image && file_exists(public_path('uploads/' . $post->image))) {
            unlink(public_path('uploads/' . $post->image));
        }

        $post->delete();

        return $this->sendResponse([], 'Post deleted successfully');
    }

    public function indexForUsers()
    {
        // Get all posts created by admin
        $data = Post::all();

        return $this->sendResponse($data, 'All posts fetched successfully');
    }
}

