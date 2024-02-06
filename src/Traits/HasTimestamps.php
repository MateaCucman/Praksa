<?php
namespace Matea\Praksa\Traits;

trait HasTimestamps
{
    protected bool $timestampsEnabled = false;
    public array|string|null $created_at;
    public ?string $updated_at;

    public function enableTimestamps(): void
    {
        $this->timestampsEnabled = true;
    }

    public function setCreatedAt(): void
    {
        if($this->timeStampsEnabled){
            $this->created_at = date('d.m.Y H:i:s');
        }
    }

    public function setUpdatedAt(): void
    {
        if($this->timestampsEnabled){
            $this->updated_at = date('d.m.Y H:i:s');
        }
    }

}