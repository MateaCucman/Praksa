<?php
namespace Matea\Praksa\Traits;

trait SoftDelete
{
    public ?string $deleted_at;

    public function getSoftDelete(): string
    {
        $this->deleted_at = date('d.m.Y H:i:s');
        return $this->deleted_at;
    }
}