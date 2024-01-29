<?php
namespace Matea\Praksa;

use Matea\Praksa\Connection;

class Model
{
    protected string $tableName;
    protected int|string $primaryKey;
    public array $attributes;

    public function save()
    {
        $columns = implode(', ', array_keys($this->attributes));
        $values = implode(', ', array_fill(0, count($this->attributes), '?'));

        
        $this->primaryKey = Connection::getInstance()->insert($this->tableName, $this->attributes);
        echo $this->primaryKey;
        $data = self::find($this->primaryKey)->toArray();
        $this->attributes = $data;
    }

    public function update()
    {

    }

    static public function find($primaryKey): ?Model
    {
        $instance = new static();
        $query = "SELECT * FROM $instance->tableName WHERE $instance->primaryKey = ?";
        $data = Connection::getInstance()->fetchAssoc($query, [$primaryKey]);

        if ($data) {
            $instance->attributes = $data;
            return $instance;
        }

        return null;
    }

    public function toArray(): array
    {
        return $this->attributes;
    }
}


// class Model
// {
//     protected string $table = '';
//     protected string|int $primaryKey;
//     protected array $attributes = [];

//     public function save()
//     {
//         $columns = implode(', ', array_keys($this->attributes));
//         $values = implode(', ', array_fill(0, count($this->attributes), '?'));

//         $query = "INSERT INTO {$this->table} ({$columns}) VALUES ({$values})";
//         $stmt = $this->executeQuery($query, array_values($this->attributes));

//         $this->{$this->primaryKey} = $this->getConnection()->lastInsertId();
//     }

//     public function update()
//     {
//         $setClause = implode(', ', array_map(function ($column) {
//             return "$column = ?";
//         }, array_keys($this->attributes)));

//         $query = "UPDATE {$this->table} SET {$setClause} WHERE {$this->primaryKey} = ?";
//         $values = array_merge(array_values($this->attributes), [$this->{$this->primaryKey}]);

//         $this->executeQuery($query, $values);
//     }

//     public static function find($primaryKey)
//     {
//         $instance = new static();
//         $query = "SELECT * FROM {$instance->table} WHERE {$instance->primaryKey} = ?";
//         $stmt = $instance->executeQuery($query, [$primaryKey]);
//         $data = $stmt->fetch(PDO::FETCH_ASSOC);

//         if ($data) {
//             $instance->fill($data);
//             return $instance;
//         }

//         return null;
//     }

//     public function toArray()
//     {
//         return $this->attributes;
//     }

//     protected function fill($data)
//     {
//         $this->attributes = $data;
//     }

//     protected function getConnection()
//     {
//         // Implement your database connection logic here
//     }

//     protected function executeQuery($query, $values)
//     {
//         $stmt = $this->getConnection()->prepare($query);
//         $stmt->execute($values);
//         return $stmt;
//     }
// }

// // Primjer kako bi koristili ovu klasu:

// class User extends Model
// {
//     protected string $table = 'users';
//     protected string|int $primaryKey = 'id';
// }

// // Kreiranje nove instance, postavljanje atributa i spremanje u bazu
// $user = new User();
// $user->attributes = [
//     'username' => 'john_doe',
//     'email' => 'john@example.com',
//     'password' => 'hashed_password',
// ];
// $user->save();

// // Ažuriranje postojeće instance
// $existingUser = User::find(1);
// $existingUser->attributes['email'] = 'new_email@example.com';
// $existingUser->update();

// // Dohvaćanje instance iz baze
// $foundUser = User::find(1);
// var_dump($foundUser->toArray());



// public function save()
// {
//     $columns = implode(', ', array_keys($this->attributes));
//     $values = implode(', ', array_fill(0, count($this->attributes), '?'));

//     $query = "INSERT INTO {$this->table} ({$columns}) VALUES ({$values})";
//     $stmt = $this->executeQuery($query, array_values($this->attributes));

//     $this->{$this->primaryKey} = $this->getConnection()->lastInsertId();
// }