<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Models\Category;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;

class PostMobileController extends Controller
{
    public function createpost(Request $request)
    {
        try {
            $newPost = Post::create([
                'user_id' => $request->input("user_id"),
                'category_id' => $request->input("category_id"),
                'body' => $request->input("body"),
            ]);

            // Return a successful JSON response
            return response()->json([
                'success' => true,
                'message' => 'Post created successfully',
                'data' => $newPost,
            ]);
        } catch (\Exception $error) {
            // Return an error response
            return response()->json([
                'success' => false,
                'error' => 'Failed to create Post',
                'message' => $error->getMessage(),
            ], 500);
        }
    }

    public function get()
    {
        $posts =  Post::select("id", "user_id", "category_id", "body", "created_at")->orderBy("created_at", "desc")->get();

        $posts->each(function ($post) {
            $parent = User::find($post->user_id);
            if ($parent) {
                $post->parentName = $parent->name;
                $post->parentLevel = $parent->account_level;
                $imageUrl = asset('storage/' . $parent->image);
                $post->parentImage = $imageUrl;
            }
        });

        $posts->each(function ($post) {
            $category = Category::find($post->category_id);
            if ($category) {
                $post->categoryName = $category->name;
            }
        });

        return response()->json([
            "data" => $posts
        ]);
    }

    // public function uploadImage(Request $request)
    // {
    //     if ($request->hasFile('image')) {
    //         $image = $request->file('image');
    //         $imageName = time() . '.' . $image->getClientOriginalExtension();
    //         $image->move(public_path('images'), $imageName);
    //         $imageUrl = asset('images/' . $imageName);

    //         return response()->json(['success' => true, 'message' => 'Image uploaded successfully', 'data' => $imageUrl]);
    //     } else {
    //         return response()->json(['success' => false, 'message' => 'No image uploaded']);
    //     }
    // }
}
