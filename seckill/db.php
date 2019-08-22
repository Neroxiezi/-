<?php
    /**
     * Created By ${pROJECT_NAME}.
     * User: pfinal
     * Date: 2019/8/22
     * Time: 上午10:25
     * ----------------------------------------
     *
     */

    class Model
    {
        protected $link;

        public function __construct()
        {
            $this->link = mysqli_connect('127.0.0.1', 'root', 'root');\
            mysqli_select_db($this->link,'seckill');
        }

        public function exec($sql)
        {
            $res = $this->link->query($sql);
            if ($res && mysqli_fetch_rows($this->link)) {
                return true;
            } else {
                return false;
            }
        }
    }

    $mod = new Model();




