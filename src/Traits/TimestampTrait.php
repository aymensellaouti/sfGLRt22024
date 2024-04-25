<?php

namespace App\Traits;

use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\ORM\Mapping\PreUpdate;
use Doctrine\ORM\Mapping as ORM;
trait TimestampTrait
{

    #[ORM\Column()]
   private \DateTime $createdAt;

    #[ORM\Column()]
    private \DateTime $updatedAt;

    #[PrePersist()]
    public function onPreCreate() {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }
    #[PreUpdate()]
    public function onPreUpdate() {
        $this->updatedAt = new \DateTime();
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}