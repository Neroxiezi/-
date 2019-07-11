<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function get_key()
    {
        return '这个是方法调用的';
    }
}
