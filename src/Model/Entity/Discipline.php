<?php

namespace Cleitoncunha\Bird\Model\Entity;

readonly class Discipline
{
    public function __construct(
        public readonly int    $id,
        public readonly string $name,
    )
    {
    }
}