<?php

namespace Cleitoncunha\Bird\Model\Entity;

readonly class File
{
    public function __construct(
        public int $id,
        public string $name,
        public string $fileName,
        public int $topicId,
    )
    {
    }
}