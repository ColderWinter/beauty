<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/19
 * Time: 16:11
 */

namespace Beauty;


/**
 * Class Route
 *
 * @package Beauty
 */
class Route
{
    /**
     * 路由表
     *
     * @var array
     */
    public static $routes = [];

    /**
     * 分组路由的域名
     * @var string|null
     */
    private static $domain = null;

    /**
     * 分组路由的命名空间
     * @var string|null
     */
    private static $namespace = null;

    /**
     * 向路由表中添加路由
     *
     * 此方法需要在static::group的callback方法中调用，不能直接调用
     *
     * @param string $path 路由路径，类似：www.abc.com/user/get
     * @param string $action 要执行的方法，类似：App\Controller\UserController@getUserName
     *
     * @return void
     * @throws \Exception
     */
    public static function add($path, $action)
    {
        $routes = static::$routes;

        $domain = static::$domain;
        $namespace = static::$namespace;


        $path = $domain . $path;
        $action = $namespace . '\\' . $action;

        foreach ($routes as $route) {
            if ($route['path'] == $path) {
                throw new \Exception("路由已存在：$path");
                break;
            }
        }

        static::$routes[] = compact('path', 'action');
    }

    /**
     * 分组添加路由
     *
     * 向不同的域名和命名空间添加路由，callback要用static::add方法
     *
     * @param string   $domain 该组路由的域名
     * @param string   $namespace 该组路由的控制器方法的命名空间
     * @param callable $callback 回调函数，在该回调函数中调用static::add函数
     *
     * @return void
     */
    public static function group($domain, $namespace, callable $callback)
    {
        static::$domain = $domain;
        static::$namespace = $namespace;

        call_user_func($callback);

        static::$domain = null;
        static::$namespace = null;
    }
}