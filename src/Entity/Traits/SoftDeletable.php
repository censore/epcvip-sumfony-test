<?php

namespace App\Entity\Traits;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

trait SoftDeletable
{
    /**
     * @ORM\Column(type="datetime", nullable=true, options={"comment":"Datetime record of row deletion"})
     */
    private $deletedAt;

    /**
     * Returns date on which entity has been deleted.
     *
     * @return DateTime|null
     */
    public function getDeletedAt(): ?DateTime
    {
        return $this->deletedAt;
    }

    /**
     * Set the delete date to given date.
     *
     * @param DateTime|null $deletedAt
     *
     * @return self
     */
    public function setDeletedAt(?DateTime $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * Marks the entity as deleted.
     */
    public function delete(): void
    {
        $this->setDeletedAt($this->currentDateTime());
    }

    /**
     * Restore the entity by nulling deleted datetime
     */
    public function restore(): void
    {
        $this->setDeletedAt(null);
    }

    /**
     * Checks whether the entity has been deleted.
     *
     * @return bool
     */
    public function isDeleted(): bool
    {
        if (null !== $this->getDeletedAt()) {
            return $this->getDeletedAt() <= $this->currentDateTime();
        }

        return false;
    }

    /**
     * Get a instance of DateTime with the current data time.
     *
     * @return DateTime
     */
    private function currentDateTime(): DateTime
    {
        $dateTime = new DateTime;

        return $dateTime;
    }
}