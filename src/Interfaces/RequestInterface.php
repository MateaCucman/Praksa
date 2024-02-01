<?php

namespace Matea\Praksa\Interfaces;

interface RequestInterface
{
    public function setAttr(array $attrs): void;
    public function is_set(string $key): bool;
    public function getAttr(string $key): string;
    public function getAttrs(): array;
    public function getBody(): array;
    public function getParam(string $key): ?string;
    public function getMethod(): string;
    public function getUri(): string;
}