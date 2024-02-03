<?php
namespace Matea\Praksa\Traits;

trait Timestamp
{
    protected bool $timestampEnabled = false;
    public ?string $created_at;
    public ?string $updated_at;

    public function enableTimestamp(): void
    {
        $this->timestampEnabled = true;
    }

    public function getCreatedAt(): ?string
    {
        $this->created_at = date('d.m.Y H:i:s');
        return $this->timestampEnabled ? $this->created_at : null;
    }

    public function getUpdatedAt(): ?string
    {
        $this->updated_at = date('d.m.Y H:i:s');
        return $this->timestampEnabled ? $this->updated_at : null;
    }

}