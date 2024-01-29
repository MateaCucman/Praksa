<?php
namespace Matea\Praksa;

use Matea\Praksa\Model;

class Products extends Model
{
    protected int|string $primaryKey = 'id';
    protected string $tableName = 'products';
    public string $name = '';
    public string $type = '';
    public array $attributes = [];
}