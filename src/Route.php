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
     * 添加路由
     *
     * @param $domain
     * @param $path
     * @param $namespace
     * @param $class
     * @param $method
     *
     * @throws \Exception
     */
    public static function add($domain, $path, $namespace, $class, $method)
    {
        $routes = static::$routes;

        foreach ($routes as $route) {
            if (($route['domain'] == $domain) && ($route['path']) == $path) {
                throw new \Exception("路由已存在：$domain/$path");
                break;
            }
        }

        static::$routes[] = compact('domain', 'path', 'namespace', 'class', 'method');
    }
}