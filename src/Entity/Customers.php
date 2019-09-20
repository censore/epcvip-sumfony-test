<?php


namespace App\Entity;


use App\Entity\Traits\EnumValues;
use App\Entity\Traits\SoftDeletable;
use App\Entity\Traits\Timestampable;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Repository\CustomersRepository;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CustomersRepository")
 * @ORM\Table(name="customers")
 * @ORM\HasLifecycleCallbacks
 */

class Customers
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

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", options={
     *     "unsigned": true,
     * })
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="firstName", type="string", length=255, options={"comment":"Customer first name"})
     *
     * @Assert\NotBlank(message="Customer name cannot be blank")
     * @Assert\Length(
     *     min=2,
     *     max=50
     * )
     */
    private $firstName;

    /**
     * @ORM\Column(name="lastName", type="string", length=255, options={"comment":"Customer last name"})
     *
     * @Assert\NotBlank(message="Customer lastname cannot be blank")
     * @Assert\Length(
     *     min=3,
     *     max=255
     * )
     */
    private $lastName;

    /**
     * @ORM\Column(name="dateOfBirth", type="datetime", nullable=true, options={"comment":"Datetime record of row date of birth"})
     */
    private $dateOfBirth;

    /**
     * @ORM\Column(type="string", columnDefinition="ENUM('new', 'pending', 'review','approved','inactive','deleted')")
     */
    private $status ='new';

    /**
     * @var Collection|Products[]
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Products", mappedBy="customer")
     */

    private $product;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
        $this->products = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * Returns date of birth
     *
     * @return DateTime|null
     */
    public function getDateOfBirth(): ?DateTime
    {
        return $this->dateOfBirth;
    }

    /**
     * @param mixed $dateOfBirth
     */
    public function setDateOfBirth($dateOfBirth): void
    {
        $this->dateOfBirth = $dateOfBirth;
    }

    /**
     * @return Products[]|Collection
     */
    public function getProducts()
    {
        return $this->product;
    }

    /**
     * @param Products[]|Collection $products
     */
    public function setProducts($products): void
    {
        $this->product = $products;
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
    public function getId()
    {
        return $this->id;
    }


}