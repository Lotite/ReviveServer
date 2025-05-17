<?php
interface EntidadBase
{
    public static function getTableName(): string;
    public static function getPrimaryKey(): string;
    public static function getColumns(): array;
    public static function create(array $data): self;
    public function save(): bool;
    public function update(array $data): bool;
    public function delete(): bool;
    public static function findById(int $id): ?self;
    public static function all(): array;
}
?>