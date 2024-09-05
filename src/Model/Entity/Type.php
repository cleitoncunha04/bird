<?php

namespace Cleitoncunha\Bird\Model\Entity;

readonly class Type
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
    )
    {
    }
}