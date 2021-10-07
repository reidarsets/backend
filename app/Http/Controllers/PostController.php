<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Like;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PostController extends Controller
{
    public function get_posts(Request $request) {
        return Post::get();
    }
    public function get_post(Request $request, $id) {
        return Post::find($id);
    }
    public function get_comments(Request $request, $id) {
        $post = Post::where('post_id', $id)->get()->all();
        if ($post == null) {
            return response([
                'message' => 'There is no such post!'
            ], 401);
        }
        $comments = Comment::where('post_id', $post_id)->get()->toArray();
        if ($comments == null) {
            return response([
                'message' => 'There are no comments!'
            ], 401);
        }
        return $comments;
    }
    public function create_comment(Request $request, $id) {
        $post = Post::where('post_id', $id)->get()->all();
        if ($post == null) {
            return response([
                'message' => 'There is no such post!'
            ], 401);
        }
        $comment = Comments::create([
            'user_id' => $this->user->id,
            'post_id' => $post_id,
            'content' => $request->input('content')
        ]);
        return $comment;
    }
    public function get_likes(Request $request, $id) {
        $like = Like::where('post_id', $id)->get()->all();
        if ($like == null) {
            return response([
                'message' => 'There are no likes!'
            ], 401);
        }
        return $like;
    }
    public function create_post(Request $request) {
        $data = [
            'user_id' => $this->user->id,
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'category_id' => $request->input('category_id'),
            'status' => $request->input('status')
        ];
        return Post::create($data);
    }
    public function create_like(Request $request, $id) {
        $post = Post::find($id);
        if($post == null) {
            return response("There is no post with such id!", 401);
        }
        $data = [
            'user_id' => auth()->user()->id,
            'entity' => 'comment',
            'entity_id' => $comment_id
        ];
        return Like::create($data);
    }
    public function update_post(Request $request, $id) {
        $post = Post::find($id);
        if($post == null) {
            return response("There is no post with such id!", 401);
        }
        if(auth()->user()->login == $post->author || auth()->user()->role == 'admin') {
            $post->update($request->all());
            return response([
                'message' => 'Post updated'
            ]);
        }
        else {
            return response("Access denied!", 401);
        }
    }
    public function delete_post(Request $request, $id) {
        $post = Post::find($id);
        if($post == null) {
            return response("There is no post with such id!", 401);
        }
        if(auth()->user()->login == $post->author || auth()->user()->role == 'admin') {
            return Post::destroy($id);
        }
        else {
            return response("Access denied!", 401);
        }
    }
    public function delete_like(Request $request, $id) {
        $like = Like::where('post_id', $id)->get()->all();
        if ($like == null) {
            return response([
                'message' => 'There are no likes!'
            ], 401);
        }
        return Like::destroy($id);;
    }
}
