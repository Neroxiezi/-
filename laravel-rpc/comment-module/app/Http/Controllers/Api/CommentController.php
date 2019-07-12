<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    public static function comment_content()
    {
        return view('modules.comment.comment_content')->render();
    }

    public static function comment_save(Request $request)
    {
        dd($request->all());
    }

    public static function get_csrf_token()
    {
        return 'foo({"csrf_token": "'.csrf_token().'"});';
    }
}
