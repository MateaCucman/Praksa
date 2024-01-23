<?php

namespace Matea\Praksa\Interfaces;

interface RequestInterface
{
    public function getParams(string $key): ?string;
    public function is_set(string $key): bool;
    public function getMethod(): string;
    public function getUri(): string;
}