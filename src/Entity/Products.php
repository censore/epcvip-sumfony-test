<?php

namespace App\Entity;

use App\Entity\Traits\EnumValues;
use App\Entity\Traits\SoftDeletable;
use App\Entity\Traits\Timestampable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Repository\ProductsRepository;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductsRepository")
 * @ORM\Table(name="products")
 * @ORM\HasLifecycleCallbacks
 */
class Products
{
    use Timestampable,
        SoftDeletable,
        EnumValues;

    const PRODUCT_NEW = 'new';
    const PRODUCT_PENDING = 'pending';
    const PRODUCT_REVIEW = 'in review';
    const PRODUCT_APPROVED = 'approved';
    const PRODUCT_INACTIVE = 'inactive';
    const PRODUCT_DELETED = 'deleted';

    protected static $possibleValues = [
            self::PRODUCT_NEW => 'New',
            self::PRODUCT_PENDING => 'Pending',
            self::PRODUCT_REVIEW => 'In Review',
            self::PRODUCT_APPROVED => 'Approved',
            self::PRODUCT_INACTIVE => 'Inactive',
            self::PRODUCT_DELETED => 'Deleted',
    ];

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", options={
     *     "unsigned": true,
     * })
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="name", type="string", length=255, options={"comment":"Product first name"})
     *
     * @Assert\NotBlank(message="Product name cannot be blank")
     * @Assert\Length(
     *     min=2,
     *     max=50
     * )
     */
    private $name;

    /**
     * @Assert\Choice(callback="getPossibleTypes")
     * @ORM\Column(type="string", columnDefinition="ENUM('new', 'pending', 'in review','approved','inactive','deleted')")
     */
    private $status ='new';

    /**
     * @ORM\Column(type="integer", name="customer_id")
     */
    private $customer;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
        $this->customer = new ArrayCollection();
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('name', new Assert\NotBlank());
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->isTypeExist($status);
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getCustomer()
    {
        return $this->customer_id;
    }

    /**
     * @param mixed $customer_id
     */
    public function setCustomerId($customer_id): void
    {
        $this->customer_id = $customer_id;
    }

}