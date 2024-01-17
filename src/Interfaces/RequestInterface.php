<?php

namespace Matea\Praksa\Interfaces;

interface RequestInterface
{
    public function getParams($key);
    public function is_set($key);
    public function getMethod();
    public function getUri();
}