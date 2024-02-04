<?php
namespace Matea\Praksa\Traits;

trait Timestamp
{
    protected bool $timestampEnabled = false;
    public array|string|null $created_at;
    public ?string $updated_at;

    public function enableTimestamp(): void
    {
        $this->timestampEnabled = true;
    }

    public function getCreatedAt(): void
    {
        $this->created_at = date('d.m.Y H:i:s');
    }

    public function getUpdatedAt(): void
    {
        $this->updated_at = date('d.m.Y H:i:s');
    }

}