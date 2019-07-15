<?php

namespace App\Http\Controllers\Api;

use App\Model\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentClientController extends Controller
{
    protected $client;
    public $comment;

    public function __construct(Comment $comment)
    {
        try {
            $this->client = \Hprose\Socket\Client::create('tcp://127.0.0.1:1314', false);
            $this->comment = $comment;
        } catch (\ErrorException $exception) {
            $this->client = '';
        } catch (\Exception $e) {
            $this->client = '';
        }
    }

    public function index()
    {
        $res = '';
        try {
            $this->client->comment_content();
            if ($this->client) {
                $res = $this->client->comment_content();
            }
        } catch (\Exception $e) {
            $res = response()->json(['code' => 505, 'msg' => '服务器未启动']);
        }

        return $res;
    }

    public function comment_save(Request $request)
    {
        //dd($request->all());
        // TODO 判断是否有登陆

        // TODO 做数据检测

        $params['member_id'] = $request->input('member_id');
        $params['content'] = $request->input('content');
        $params['pid'] = $request->input('parent_id');
        $params['referer_url'] = $request->input('referer_url');
        $params['obj_id'] = $request->input('obj_id');
        try {
            $this->comment->create_comment($params);
            return response()->json(
                ['code' => 200, 'msg' => '评论成功', 'data' => ['referer_url' => $params['referer_url']]]
            );
        } catch (\Exception $e) {
            return response()->json(
                ['code' => 405, 'msg' => $e->getMessage(), 'data' => ['referer_url' => $params['referer_url']]]
            );
        }
    }
}
