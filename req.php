<?php

interface RequestInterface
{
    public function get($key);
    public function post($key);
    public function is_set($key);
    
}

class Request implements RequestInterface
{
    private $getParams;
    private $postParams;

    public function __construct()
    {
        $this->getParams = $_GET;
        $this->postParams = $_POST;
        
    }

    public function is_set($key)
    {
        return isset($_POST[$key]);
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