<?php

namespace Cleitoncunha\Bird\Model\Repository;

interface RepositoryInterface
{
    public function findAll() : array;

    public function findById(int $id) : array;

    public function save(object $object) : bool;

    public function remove(int $id) : bool;
}