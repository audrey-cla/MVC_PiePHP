<?php

namespace Core;

class Router
{
    public static $id;
    private static $routes;
    private static $url;

    public function __construct()
    {
        $id = '';
        $this->id = $id;
    }

    public static function connect($url, $route)
    {
        self::$routes[$url] = $route;

        $regex = '~\{([^}]*)\}~';
        preg_match_all($regex, $url, $matches);
        $matches = array_filter($matches);

        if (!empty($matches)) {
            if (is_array(self::$url)) {
                array_push(self::$url, $url);
            } else {
                self::$url = [$url];
            }
        }
    }

    public static function get($url)
    {
        $url = preg_replace('/^\//', '', $url);
        if (array_key_exists($url, self::$routes)) {
            return  self::$routes[$url];
        } else {
            if (isset(self::$url)) {
                foreach (self::$url as $values) {
                    $url_id = explode('/', $url);
                    $url_id = array_pop($url_id);
                    
                    $url1 = substr($values, 0, strrpos($values, '/') + 1);
                    $url2 = substr($url, 0, strrpos($url, '/') + 1);
                    if ($url2 == $url1) {
                        self::$id = $url_id;
                        return self::$routes[$values];
                    }
                }
            }
        }
    }
}
