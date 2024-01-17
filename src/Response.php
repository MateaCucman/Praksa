<?php

namespace Matea\Praksa;
use Matea\Praksa\Interfaces\ResponseInterface;

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