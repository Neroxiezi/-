<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    public function comment_content()
    {
        return view('modules.comment.comment_content');
    }
}
