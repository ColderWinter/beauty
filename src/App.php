<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/19
 * Time: 15:29
 */

namespace Beauty;


class App
{
    public function handle(Request $request)
    {
        if (! isset($_SERVER['PATH_INFO'])) {
            throw new \Exception('请开启PATH_INFO');
        }

        $domain = $_SERVER['HTTP_HOST'];
        $path = $pathInfo = $_SERVER['PATH_INFO'];

        $result = self::route($domain, $path, $request);

        if (is_array($result)) {
            header('Content-type: application/json');
            echo json_encode($result);
        } else {
            echo $result;
        }
    }

    /**
     * 执行路由方法
     *
     * @param string  $domain
     * @param string  $path
     * @param Request $request
     *
     * @return mixed
     */
    private static function route($domain, $path, Request $request)
    {
        $namespace = '';
        $class = '';
        $method = '';

        $routes = Route::$routes;
        foreach ($routes as $route) {
            if (($route['domain'] == $domain) && ($route['path']) == $path) {
                $namespace = $route['namespace'];
                $class = $route['class'];
                $method = $route['method'];

                break;
            }
        }

        $class = $namespace . '\\' . $class;

        $class = new $class();

        $params = self::reflectParams($class, $method, $request);

        return call_user_func_array([$class, $method], $params);
    }

    /**
     * 反射获取调用指定类实例中方法所需的参数列表
     *
     * @param mixed   $instance 类的一个实例
     * @param string  $method 类中要被调用的方法
     * @param Request $request 请求数据
     *
     * @return array
     * @throws \Exception
     */
    private static function reflectParams($instance, $method, Request $request) {
        //反射获取调用方法所需的参数列表
        $funcRef = new \ReflectionMethod($instance, $method);
        $funcParams = $funcRef->getParameters();

        //取各参数的默认值及是否有默认值
        $funcParamNames = array();
        foreach ($funcParams as $param) {
            if ($param->isDefaultValueAvailable()) {
                $funcParamNames[$param->getName()] = array('hasDefaultValue'=>true, 'defaultValue'=>$param->getDefaultValue());
            } else {
                $funcParamNames[$param->getName()] = array('hasDefaultValue'=>false, 'defaultValue'=>'');
            }
        }

        //构造调用接口方法时的参数表
        $params = array();
        foreach($funcParamNames as $name=>$defaultValue) {
            if($request->$name !== null) {
                $params[] = $request->$name;
            } else {
                if ($defaultValue['hasDefaultValue']) {
                    $params[] = $defaultValue['defaultValue'];
                } else {
                    throw new \Exception("缺少必选参数:$name", 50005);
                }
            }
        }

        unset($funcRef, $funcParams, $funcParamNames, $name, $defaultValue);
        return $params;
    }
}