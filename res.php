<?php

interface ResponseInterface
{
    public function send(): string;
}

class Response implements ResponseInterface
{
    private $content;

    public function __construct($content)
    {
        $this->content = $content;
    }

    public function send(): string
    {
        echo $this->content;
        return $this->content;
    }
}