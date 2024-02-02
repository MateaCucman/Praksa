<?php
namespace Matea\Praksa;

use Matea\Praksa\Model;

class Product extends Model
{
    protected int|string $primaryKey = 'id';
    protected string $tableName = 'products';
    public string|array $name = '';
    public string|array $type = '';
}