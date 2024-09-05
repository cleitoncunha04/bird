<?php

namespace Cleitoncunha\Bird\Model\Entity;

readonly class Topic
{
    public function __construct(
        public int    $id,
        public string $name,
    )
    {
    }
}