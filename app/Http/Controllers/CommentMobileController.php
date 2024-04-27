<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentMobileController extends Controller
{
    public function getComments(Request $request)
    {

        try {
            $comments = Comment::select("user_id", "body", "created_at")->where("commentable_id", $request->input('commentable_id'))->orderBy("created_at", 'desc')->get();

            $comments->each(function ($comment) {
                $parent = User::find($comment->user_id);
                if ($parent) {
                    $comment->parentName = $parent->name;
                    $comment->parentLevel = $parent->account_level;
                    $imageUrl = asset('storage/' . $parent->image);
                    $comment->parentImage = $imageUrl;
                }
            });
            return response()->json([
                "data" => $comments
            ]);
        } catch (\Exception $error) {
            return response()->json([
                'success' => false,
                'error' => 'Failed to add comment',
                'message' => $error->getMessage(),
            ], 500);
        }
    }

    public function storeComment(Request $request)
    {
        try {
            $newComment = Comment::create([
                'user_id' => $request->input("user_id"),
                'commentable_id' => $request->input("commentable_id"),
                'body' => $request->input("body"),
                'commentable_type' => "App\Models\Post"
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Comment added successfully',
                'data' => $newComment,
            ]);
        } catch (\Exception $error) {
            return response()->json([
                'success' => false,
                'error' => 'Failed to add comment',
                'message' => $error->getMessage(),
            ], 500);
        }
    }
}
