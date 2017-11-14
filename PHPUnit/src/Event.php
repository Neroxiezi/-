<?php
namespace Src;

class Event {
    /**
     * @var int event id
     */
    public $id;

    /**
     * @var string 事件名
     */
    public $name;

    /**
     * @var string 事件开始时间
     */
    public $startDate;

    /**
     * @var string 事件结束时间
     */
    public $endDate;

    /**
     * @var int 参加者限制
     */
    public $attendLimit;

    /**
     * @var array 参加者列表
     */
    public $attendArr = array();

    public function __construct($id, $name, $startDate, $endDate, $attendLimit) {
        $this->id          = $id;
        $this->name        = $name;
        $this->startDate   = $startDate;
        $this->endDate     = $endDate;
        $this->attendLimit = $attendLimit;
    }

    /**
     * 用户报名，将报名的用户存在数组中，数组的索引值就是用户的id
     * @param $user
     * @return bool
     * @throws \Exception
     */
    public function reserve($user) {
        // 报名人数是否超过限制
        if ($this->attendLimit > $this->getAttendNumber()) {
            if (array_key_exists($user->id, $this->attendArr)) {
                throw new \Exception('Duplicated reservation', \Exception::DUPLICATED_RESERVATION);
            }
            // 使用者报名
            $this->attendArr[$user->id] = $user;
            return true;
        }
        return false;
    }

    /**
     * 获取报名用户的人数
     *
     * @return int
     */
    public function getAttendNumber() {
        return sizeof($this->attendArr);
    }

    /**
     * 取消报名
     *
     * @param $user
     */
    public function unReserve($user) {
        unset($this->attendArr[$user->id]);
    }
}