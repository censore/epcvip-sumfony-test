<?php


namespace App\DTO;


use App\Entity\Products;

class ProductDTO
{

    private $id;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Name of product must be at least {{ limit }} characters long",
     *      maxMessage = "Name of product cannot be longer than {{ limit }} characters"
     * )
     */
    private $name;

    /**
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Choice(callback="getStatusTypes")
     */
    private $statusType;

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getStatus(): ?int
    {
        return $this->statusType;
    }

    public function setStatus(?int $statusType): void
    {
        $this->statusType = $statusType;
    }

    public static function getStatusTypes(): array
    {
        return (new Products())->getPossibleTypes();
    }

}