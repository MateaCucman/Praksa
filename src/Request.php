<?php

namespace Matea\Praksa;
use Matea\Praksa\Interfaces\RequestInterface;

class Request implements RequestInterface
{
    private $url;
    private $method;
    private $Params;

    public function __construct()
    {
        $this->url = $_SERVER['REQUEST_URI'];
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->Params = array_merge($_GET, $_POST);
    }

    public function is_set($key)
    {
        return isset($_POST[$key]);
    }

    public function getParams($key)
    {
        return isset($this->Params[$key]) ? $this->Params[$key] : null;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getUri()
    {
        return $this->url;
    }
}