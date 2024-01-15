<?php

interface RequestInterface
{
    public function get($key);
    public function post($key);
}

class Request implements RequestInterface
{
    private $getParams;
    private $postParams;

    public function __construct($getParams, $postParams)
    {
        $this->getParams = $getParams;
        $this->postParams = $postParams;
    }

    public function get($key)
    {
        return isset($this->getParams[$key]) ? $this->getParams[$key] : null;
    }

    public function post($key)
    {
        return isset($this->postParams[$key]) ? $this->postParams[$key] : null;
    }
}