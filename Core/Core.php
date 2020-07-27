<?php

namespace Core;

use Core\Router;

require_once("routes.php");

class Core
{
    public function run()
    {
        $name = new \src\Name();
        $name = $name->getName();
        $control = $act =  "";
        $url = array_filter(explode("/", trim($_SERVER['REQUEST_URI'])));
        $url2 = str_replace("$name", '', $_SERVER['REQUEST_URI']);

        if (Router::get($url2)) {
            $control = Router::get($url2)["controller"];
            $act = Router::get($url2)["action"];
        } else {
            if ((count($url)) > 1) {
                $control = $url[2];
                if (isset($url[3])) {
                    $act = $url[3];
                } else {
                    $act = "index";
                }
            } else {
                $control = "app";
                $act = "index";
            }
        }

        $controller = "src\\Controller\\" . ucfirst(strtolower($control)) . "Controller";
        $action = strtolower($act) . "Action";

        if (class_exists($controller)) {
            $app = new $controller();
            if (method_exists($controller, $action)) {
                $app->$action(Router::$id);
            } else {
                $app->indexAction();
            }
        } else {
            echo "404";
        }
    }
}

$app = new Controller();
$app->action();