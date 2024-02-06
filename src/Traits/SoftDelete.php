<?php
namespace Matea\Praksa\Traits;

trait SoftDelete
{
    public ?string $deleted_at;

    public function softDelete(): void
    {
        $this->deleted_at = date('d.m.Y H:i:s');
    }
}