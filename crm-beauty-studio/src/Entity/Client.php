<?php
declare(strict_types=1);

namespace App\Entity;

class Client
{
    private ?int $id;
    private string $phone;
    private string $firstName;
    private string $lastName;

    public function __construct(
        ?int $id,
        string $firstName,
        string $lastName,
        ?string $phone
    )
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->phone = $phone;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function setFirstName($firstName): void
    {
        $this->firstName = $firstName;
    }

    public function setLastName($lastName): void
    {
        $this->lastName = $lastName;
    }

    public function setPhone($phone): void
    {
        $this->phone = $phone;
    }

}

