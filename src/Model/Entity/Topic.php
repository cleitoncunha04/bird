<?php

namespace Cleitoncunha\Bird\Model\Entity;

class Topic
{
    public function __construct(
        public readonly int    $id,
        public readonly string $name,
        /** @var File[] */
        private ?array $files = []
    ) {
    }

    public function addFiles(File $file): void
    {
        $this->files[] = $file;
    }

    /** @return File[] */
    public function getFiles(): array
    {
        return $this->files;
    }
}