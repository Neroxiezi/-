<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommentClientController extends Controller
{
    protected $client;

    public function __construct()
    {
        try {
            $this->client = new \Hprose\Socket\Client('tcp://127.0.0.1:1314', false);
        } catch (\ErrorException $exception) {
            $this->client = '';
        }
    }

    public function index()
    {
        $res = '';
        if ($this->client) {
            $res = $this->client->comment_content();
        }

        return $res;
    }

    public function comment_save(Request $request)
    {
        dd($_POST);
    }
}
