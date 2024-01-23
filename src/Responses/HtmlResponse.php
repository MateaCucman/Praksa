<?php

namespace Matea\Praksa\Responses;
use Matea\Praksa\Interfaces\HtmlResponseInterface;

class HtmlResponse implements HtmlResponseInterface
{
    private string $content;

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