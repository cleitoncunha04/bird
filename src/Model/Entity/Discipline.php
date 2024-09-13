<?php

namespace Cleitoncunha\Bird\Model\Entity;

class Discipline
{
    public function __construct(
        public readonly int    $id,
        public readonly string $name,
        private ?string $bannerImage = "banner-teste-2.jpg",
        /** @var Topic[] */
        private array $topics = []
    )
    {
    }

    public function setBannerImage(string $bannerImage): void
    {
        $this->bannerImage = $bannerImage;
    }

    public function getBannerImage():  ?string {
        return $this->bannerImage;
    }

    public function addTopics(Topic $topic): void
    {
        $this->topics[] = $topic;
    }

    public function getTopics(): array
    {
        return $this->topics;
    }
}