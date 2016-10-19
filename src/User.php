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
    public function get($id, $name)
    {
        return "{$name}欢迎您，您的ID是{$id}";
    }
}