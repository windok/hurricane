<?php

namespace Hurricane\Request;

class Request
{

    private $request = [];

    public function initialize()
    {
        $putdatafp = fopen('php://input', 'r');
        $putdata = '';

        while ($data = fread($putdatafp, 1024)) {
            $putdata .= $data;
        }

        fclose($putdatafp);
        parse_str($putdata, $phpInput);

        $this->request = array_merge($_GET, $_POST, $phpInput);
    }

    public function getAll()
    {
        return $this->request;
    }

    public function get($name)
    {
        if (!$this->has($name)) {
            return null;
        }

        return $this->request[$name];
    }

    public function has($name)
    {
        return array_key_exists($name, $this->request);
    }

    public function getMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function getURI()
    {
        return $_SERVER['REQUEST_URI'];
    }

    public function getQueryString()
    {
        return $_SERVER['QUERY_STRING'];
    }


}