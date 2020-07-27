<?php

namespace Core;

use \Core\Request;

class Controller
{

    public function __construct()
    {
        $this->request = new Request();
    }
    protected static $_render;
    public function action()
    {
    }

    protected function render($view, $scope = [])
    {
        extract($scope);
        $f = implode(DIRECTORY_SEPARATOR, [dirname(__DIR__), 'src', 'View', $view]) . '.php';

        if (file_exists($f)) {
            ob_start();
            include($f);
            $view = ob_get_clean();
            ob_start();
            include(implode(DIRECTORY_SEPARATOR, [dirname(__DIR__), 'src', 'View', 'index']) . '.php');

            $find = array("/{{(.*?)}}/", "/@if\((.*)\)/", "/@elseif\((.*)\)/", "/@else/", "/@endif/", "/@foreach\((.*)\)/", "/@endforeach/", "/@isset\((.*)\)/", "/@endisset/", "/@empty\((.*)\)/", "/@endempty/");
            $replace = array(
                "<?= htmlentities($1) ?>", "<?php if($1): ?>", "<?php else if($1): ?>", "<?php else: ?>", "<?php endif; ?>", "<?php foreach($1): ?>", "<?php endforeach; ?>", "<?php if(isset($1)): ?>",
                "<?php endisset; ?>", "<?php empty($1):?>", "<?php endempty; ?>"
            );
            self::$_render =  preg_replace($find, $replace, ob_get_clean());
            echo self::$_render;

        }
    }
}
