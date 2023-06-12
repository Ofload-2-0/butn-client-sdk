<?php

namespace Ofload\Butn\DTO;

use JsonSerializable;
use Ofload\Butn\ApplicationConstants;

class UserDTO implements JsonSerializable
{
    private string $aggregatorId;
    private string $borrowerExternalId;
    private string $abn;
    private string $productType = ApplicationConstants::BUTN_X_UNDISCLOSED;
    private ?string $companyName = null;
    private ?string $firstName = null;
    private ?string $lastName = null;
    private ?string $email = null;
    private ?string $phone = null;
    private ?string $street = null;
    private ?string $city = null;
    private ?string $state = null;
    private ?string $postCode = null;
    private ?string $country = null;
    private ?string $potExtension = null;
    private ?string $redirectUri = null;
    private ?BankAccountDTO $bankAccount = null;

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(?string $street): UserDTO
    {
        $this->street = $street;
        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): UserDTO
    {
        $this->city = $city;
        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(?string $state): UserDTO
    {
        $this->state = $state;
        return $this;
    }

    public function getPostCode(): ?string
    {
        return $this->postCode;
    }

    public function setPostCode(?string $postCode): UserDTO
    {
        $this->postCode = $postCode;
        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): UserDTO
    {
        $this->country = $country;
        return $this;
    }

    public function getAggregatorId(): string
    {
        return $this->aggregatorId;
    }

    public function setAggregatorId(string $aggregatorId): UserDTO
    {
        $this->aggregatorId = $aggregatorId;

        return $this;
    }

    public function setCompanyName(?string $name): UserDTO
    {
        $this->companyName = $name;

        return $this;
    }

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function getBorrowerExternalId(): string
    {
        return $this->borrowerExternalId;
    }

    public function setBorrowerExternalId(string $borrowerExternalId): UserDTO
    {
        $this->borrowerExternalId = $borrowerExternalId;

        return $this;
    }

    public function getProductType(): string
    {
        return $this->productType;
    }

    public function setProductType(string $productType): UserDTO
    {
        $this->productType = $productType;

        return $this;
    }

    public function getABN(): ?string
    {
        return $this->abn;
    }

    public function setAbn(?string $abn): UserDTO
    {
        $this->abn = $abn;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): UserDTO
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): UserDTO
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): UserDTO
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): UserDTO
    {
        $this->phone = $phone;

        return $this;
    }

    public function getPotExtension(): ?string
    {
        return $this->potExtension;
    }

    public function setPotExtension(?string $potExtension): UserDTO
    {
        $this->potExtension = $potExtension;

        return $this;
    }

    public function getRedirectUri(): ?string
    {
        return $this->redirectUri;
    }

    public function setRedirectUri(?string $uri): UserDTO
    {
        $this->redirectUri = $uri;

        return $this;
    }

    public function jsonSerialize(): array
    {
        $data = [
            'aggregatorId' => $this->getAggregatorId(),
            'abn' => $this->getABN(),
            'productType' => $this->getProductType(),
            'borrowerExternalId' => $this->getBorrowerExternalId(),
            'companyName' => $this->getCompanyName(),
            'street' => $this->getStreet(),
            'city' => $this->getCity(),
            'state' => $this->getState(),
            'postCode' => $this->getPostCode(),
            'country' => $this->getCountry(),
            'firstName' => $this->getFirstName(),
            'lastName' => $this->getLastName(),
            'email' => $this->getEmail(),
            'phone' => $this->getPhone(),
            'potExt' => $this->getPotExtension(),
            'redirectUri' => $this->getRedirectUri(),
            'directDebitAccount' => $this->bankAccount?->jsonSerialize() ?? []
        ];

        foreach ($data as $key => $value) {
            if (empty($value)) {
                unset($data[$key]);
            }
        }

        return $data;
    }
}
