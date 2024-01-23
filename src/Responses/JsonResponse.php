<?php

namespace Matea\Praksa\Responses;
use Matea\Praksa\Interfaces\JsonResponseInterface;
use JsonSerializable;
class JsonResponse implements JsonResponseInterface, JsonSerializable
{
    private array $content;

    public function __construct($content)
    {
        $this->content = $content;
    }
    public function jsonSerialize(): array
    {
        return $this->content;
    }

    public function send(): string
    {
        header('Content-Type: application/json');
        echo json_encode($this->content, JSON_PRETTY_PRINT);
        return json_encode($this->content);
    }
}