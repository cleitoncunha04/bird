<?php

namespace Cleitoncunha\Bird\Model\Entity;

readonly class User
{
    public function __construct(
        public readonly ?int   $id,
        public readonly string $username,
        public readonly string $email,
        public readonly string $password,
        public readonly string $level,
    )
    {
    }
}