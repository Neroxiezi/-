<?php
namespace Src;

class User {
    /**
     * @var int 用户id
     */
    public $id;

    /**
     * @var string 用户名
     */
    public $name;

    /**
     * @var string 用户邮箱
     */
    public $email;

    public function __construct($id, $name, $email) {
        $this->id    = $id;
        $this->name  = $name;
        $this->email = $email;
    }
}