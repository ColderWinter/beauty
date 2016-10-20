<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/19
 * Time: 17:58
 */

namespace Beauty;


class User
{
    public function getUserInformation($id, $name)
    {
        return "{$name}欢迎您，您的ID是{$id}";
    }

    public function addUser($username, $password, $name)
    {
        echo "恭喜您注册成功！您的用户名是：{$username}，您的密码是：{$password}，您的姓名是：{$name}";
    }
}