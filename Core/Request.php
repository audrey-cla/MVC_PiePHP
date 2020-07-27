<?php

namespace Core;

class Request
{

    public function __construct()
    {
        $request = [];
        foreach ($_POST as $key => $value) {
            $value = trim(stripslashes(htmlspecialchars($value)));
            $this->$key = $value;
            $request[$key] = $this->$key;
        }

        foreach ($_GET as $key => $value) {
            $value = trim(stripslashes(htmlspecialchars($value)));
            $this->$key = $value;
            $request[$key] = $this->$key;
        }

        $request = array_filter($request);
        $this->request = $request;
    }


    public function getParams()
    {
        return $this->request;
    }
}
