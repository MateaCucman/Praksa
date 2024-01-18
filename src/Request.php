<?php

namespace Matea\Praksa;
use Matea\Praksa\Interfaces\RequestInterface;

class Request implements RequestInterface
{
    private $url;
    private $method;
    private $params;
    private $body;

    public function __construct()
    {
        $this->url = $_SERVER['REQUEST_URI'];
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->setParams();
        $this->setBody();
    }

    protected function setParams() :void
    {
        $this->params = $_GET;
    }

    protected function setBody() :void
    {
        $this->body = $_POST;
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