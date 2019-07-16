<?php

namespace App\Http\Controllers\Api;

use App\Model\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use pf\arr\PFarr;

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
            return response()->json(['code' => 505, 'msg' => '服务器未启动']);
        }

        return response()->json(['code' => 200, 'data' => $res]);
    }

    public function comment_save(Request $request)
    {
        //dd($request->all());
        // TODO 判断是否有登陆

        // TODO 做数据检测

        $params['member_id'] = $request->input('member_id');
        $params['content'] = htmlspecialchars(
            trim(trim(str_replace('<p><br></p>', '', $request->input('content')), '</p>'), '<p>')
        );
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

    public function get_comment_list(Request $request)
    {
        $html = '';
        $comment_resource = [];
        //dd($request->all());
        //TODO 数据检测
        $referer_url = $request->input('referer_url');
        $page = is_int($request->input('page', 1)) ? $request->input('page', 0) : intval($request->input('page', 1));
        $comment_list = $this->comment->where('referer_url', $referer_url)->with(
            [
                'member' => function ($query) {
                    $query->select('id', 'name', 'avator');
                },
            ]
        )->limit(10)->offset(
            $page
        )->get()->toArray();
        if ($comment_list) {
            $comment_resource = PFarr::pf_get_tree($comment_list, 0, 'pid');
            $html = $this->set_html($comment_resource);
        }

        //dd($comment_resource);
        return response()->json(
            ['code' => 200, 'msg' => '', 'data' => ['html' => $html]]
        );
    }

    private function set_html($comment_resource, $parent_name = '')
    {
        $html = '<div style="border: none">';
        if (isset($comment_resource) && count($comment_resource) > 0) {
            foreach ($comment_resource as $item) {
                $html .= view(
                    'modules.comment.comment_resource',
                    ['comment_resource' => $item, 'parent_name' => $parent_name]
                )->render();
                if (isset($item['items']) && count($item['items']) > 0) {
                    $html .= '<div class="card" style="border: none;padding-left: 2rem">'.$this->set_html(
                            $item['items']
                            ,
                            $item['member']['name']
                        ).'</div>';
                }
            }
        }
        $html .= '</div>';

        return $html;
    }
}
