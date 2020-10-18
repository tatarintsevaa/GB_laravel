<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request) {
        $data = $request->all();
        if (Auth::check()) {
            $data['user_id'] = Auth::id();
        }

        $this->validate($request, Comment::rules());

        $comment = new Comment();
        $result = $comment->fill($data)->save();

        return response($comment->jsonSerialize(), Response::HTTP_OK);
    }
}
