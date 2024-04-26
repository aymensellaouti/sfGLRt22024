<?php

namespace App\Traits;

use Doctrine\ORM\Mapping as ORM;

trait TimeStampTrait
{
    #[ORM\Column()]
    private ?\DateTime $createdAt = null;
    #[ORM\Column()]
    private ?\DateTime $updatedAt = null;

    #[ORM\PrePersist()]
    public function onPreCreate() {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
    #[ORM\PreUpdate()]
    public function onPreUpdate() {
        $this->updatedAt = new \DateTime();
    }

}