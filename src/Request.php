<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/19
 * Time: 15:48
 */

namespace Beauty;


/**
 * Class Request
 *
 * @package Beauty
 */
class Request
{
    /**
     * REQUEST Array
     * @var array
     */
    private $request;

    /**
     * GET Array
     * @var array
     */
    private $get;

    /**
     * POST Array
     * @var array
     */
    private $post;

    /**
     * COOKIE Array
     * @var array
     */
    private $cookie;

    /**
     * Request constructor.
     */
    public function __construct()
    {
        $this->request = $_REQUEST;
        $this->get = $_GET;
        $this->post = $_POST;
        $this->cookie = $_COOKIE;
    }
    
    /**
     * 获取请求数据
     *
     * @param string $name 请求数据的键名
     *
     * @return mixed|null
     */
    public function __get($name)
    {
        $request = $this->request;
        $value = null;

        if (isset($request[$name])) {
            $value = $request[$name];
        }

        return $value;
    }

    /**
     * 设置或修改请求数据
     *
     * @param string $name 键名
     * @param mixed $value 数据
     *
     * @return void
     */
    public function __set($name, $value)
    {
        $this->request[$name] = $value;
    }

    public function all()
    {
        return $this->request;
    }
}