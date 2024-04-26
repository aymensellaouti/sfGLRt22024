<?php

namespace App\Traits;

use Doctrine\ORM\Mapping as ORM;

trait TimestampTrait
{

    #[ORM\Column(length: 255)]
    private ?\DateTime $createdAt = null;

    #[ORM\PrePersist()]
    public function onCreate(){
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    #[ORM\PreUpdate()]
    public function onUpdate(){
        $this->updatedAt = new \DateTime();
    }

    #[ORM\Column(length: 255)]
    private ?\DateTime $updatedAt = null;

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

}