<?php

namespace App\Models;

class Credit
{
    public int $id;
    public string $name;
    public ?string $role;

    public function __construct(array $data = [])
    {
        $this->id = $data['id'] ?? 0;
        $this->name = $data['name'] ?? '';
        $this->role = $data['role'] ?? null;
    }

    public static function NewCredit($data): Credit
    {
        if (is_object($data)) {
            $data = (array) $data;
        }
        return new Credit($data);
    }
}
