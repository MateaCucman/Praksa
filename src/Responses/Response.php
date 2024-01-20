<?php

namespace Matea\Praksa\Responses;
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