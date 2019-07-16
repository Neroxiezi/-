<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded = [];
    protected $table = 'comment';

    public function create_comment($params)
    {
        // 过滤用户id
        try {
            $res = $this->create($params);
            if ($params['pid'] != 0) {
                $res->path = $this->find($params['pid'])->path.$params['pid'].',';
            }

            return $res->save();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function member()
    {
        return $this->belongsTo(Member::class,'member_id','id');
    }
}
