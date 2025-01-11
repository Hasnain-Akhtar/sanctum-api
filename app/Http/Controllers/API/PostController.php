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

        return $this->sendResponse($data, 'Y\'all posts');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|mimes:png,jpeg,gif|max:255',
        ]);

        if ($validator->fails()) {
            return $this->sendError( 'Invalid request data', $validator->errors()->all());
        }

        $image = $request->file('image');
        $ext = $image->getClientOriginalExtension();
        $imageName = time() . '.' . $ext;
        $image->move(public_path().'/uploads', $imageName);


        $post = Post::create([
            'title' => $request->title, //storee data in form 
            'description' => $request->description,
            'image' => $imageName,
        ]);

        return $this->sendResponse($post, 'Post created successfully');
}
    /**
     * Display the specified resource.
     */
   public function show(string $id)
{
    // Retrieve the post using the `find` method for better clarity
    $post = Post::find($id);

    // Check if the post exists
    if (!$post) {
        return response()->json([
            'status' => false,
            'message' => 'Post not found',
        ], 404);
    }

    // Prepare the data to be returned
    $data = [
        'id' => $post->id,
        'title' => $post->title,
        'description' => $post->description,
        'image' => $post->image,
        'created_at' => $post->created_at->toDateTimeString(), // Include created date if needed
        'updated_at' => $post->updated_at->toDateTimeString(), // Include updated date if needed
    ];

    return $this->sendResponse($data, 'Post retrieved successfully');
}


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
                $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|mimes:png,jpeg,gif|max:255',
        ]);

        if ($validator->fails()) {
            return $this->sendError( 'Invalid request data', $validator->errors()->all());
        }


        $post = Post::find($id);

        if (!$post) {
            return response()->json([
                'status' => false,
                'message' => 'Post not found',
            ], 404);
        }

        if (empty($request->image) || is_null($request->image)) {
            if (file_exists(public_path() . '/uploads/' . $post->image)) {
                unlink(public_path() . '/uploads/' . $post->image);
            }
        } else {
            $image = $request->file('image');
            $ext = $image->getClientOriginalExtension();
            $imageName = time() . '.' . $ext;
            $image->move(public_path() . '/uploads', $imageName);

            if (file_exists(public_path() . '/uploads/' . $post->image)) {
                unlink(public_path() . '/uploads/' . $post->image);
            }
        }

        $post = Post::where(['id'=>$id])->update([
            'title' => $request->title, //storee data in form 
            'description' => $request->description,
            'image' => $imageName,
        ]);

        return $this->sendResponse($post, 'Post updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json([
                'status' => false,
                'message' => 'Post not found',
            ], 404);
        }

        $imagePath = public_path() . '/uploads/' . $post->image;

        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        $post->delete();

        return $this->sendResponse($post, 'Post deleted successfully');
        
    }
}
