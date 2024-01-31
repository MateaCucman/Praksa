<?php

namespace Matea\Praksa;
use Matea\Praksa\Interfaces\RequestInterface;

class Request implements RequestInterface
{
    private string $url;
    private string $method;
    private array $params;
    private array $body;
    private array $attrs;

    public function __construct()
    {
        $this->url = $_SERVER['REQUEST_URI'];
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->setParams();
        $this->setBody();
        $attrs = [];
    }

    protected function setParams(): void
    {
        $this->params = $_GET;
    }

    protected function setBody(): void
    {
        $this->body = $_POST;
    }

    public function setAttr(array $attrs): void
    {
        $this->attrs = $attrs;
    }

    public function getAttr(string $attr): string
    {
        return $this->attrs[$attr];
    }

    public function getAttrs(): array
    {
        return $this->attrs;
    }

    public function getBody(): array
    {
        return $this->body;
    }

    public function is_set(string $key): bool
    {
        return isset($_POST[$key]);
    }

    public function getParam(string $key): ?string
    {
        return isset($this->Param[$key]) ? $this->Param[$key] : null;
    }

    public function getParams(): array
    {
        return $this->params;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getUri(): string
    {
        return $this->url;
    }
}