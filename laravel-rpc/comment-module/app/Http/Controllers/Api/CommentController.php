<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    protected $middleware;

    public static function comment_content()
    {
        return view('modules.comment.comment_content')->render();
    }

    public function comment_save()
    {

    }

    public static function get_csrf_token()
    {
        return 'foo({"csrf_token": "'.csrf_token().'"});';
    }
}
