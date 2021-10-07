<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CommentController extends Controller
{
    
    public function get_comment(Request $request, $id) {
        return Comment::find($id);
    }
    public function get_likes(Request $request, $id) {
        $like = Like::where('comment_id', $id)->get()->all();
        if ($like == null) {
            return response([
                'message' => 'There are no likes!'
            ], 401);
        }
        return $like;
    }
    public function create_like(Request $request, $id) {
        $comment = Comment::find($id);
        if($comment == null) {
            return response("There is no comment with such id!", 401);
        }
        $data = [
            'user_id' => auth()->user()->id,
            'entity' => 'comment',
            'entity_id' => $comment_id
        ];
        return Like::create($data);
    }
    public function update_comment(Request $request, $id) {
        $comment = Comment::find($id);
        if($comment == null) {
            return response("There is no comment with such id!", 401);
        }
        if(auth()->user()->role == 'admin' || auth()->user()->id == $comment->user_id) {
            $comment->update($request->all());
            return response([
                'message' => 'Comment updated'
            ]);
        }
        else {
            return response("Access denied!", 401);
        }
    }
    public function delete_comment(Request $request, $id) {
        $comment = Comment::find($id);
        if($comment == null) {
            return response("There is no comment with such id!", 401);
        }
        if(auth()->user()->role != 'admin' || auth()->user()->id != $comment->user_id) {
            return response("Access denied!", 401);
        }
        return Comment::destroy($id);
    }
    public function delete_like(Request $request, $id) {
        $like = Like::where('comment_id', $id)->get()->all();
        if ($like == null) {
            return response([
                'message' => 'There are no likes!'
            ], 401);
        }
        return Like::destroy($id);;
    }
}
