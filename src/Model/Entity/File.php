<?php

namespace Cleitoncunha\Bird\Model\Entity;

readonly class File
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
    )
    {
    }
}