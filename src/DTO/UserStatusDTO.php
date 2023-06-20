<?php

namespace Ofload\Butn\DTO;

use JsonSerializable;

class UserStatusDTO implements JsonSerializable
{
    private string $aggregatorId;
    private string $borrowerExternalId;
    private ?string $description;
    private ?string $code;
    private ?string $updated;
    private ?float $fundingLimit;
    private ?float $availableFunding;

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): UserStatusDTO
    {
        $this->description = $description;
        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): UserStatusDTO
    {
        $this->code = $code;
        return $this;
    }

    public function getUpdated(): ?string
    {
        return $this->updated;
    }

    public function setUpdated(?string $updated): UserStatusDTO
    {
        $this->updated = $updated;
        return $this;
    }

    public function getFundingLimit(): ?float
    {
        return $this->fundingLimit;
    }

    public function setFundingLimit(?float $fundingLimit): UserStatusDTO
    {
        $this->fundingLimit = $fundingLimit;
        return $this;
    }

    public function getAvailableFunding(): ?float
    {
        return $this->availableFunding;
    }

    public function setAvailableFunding(?float $availableFunding): UserStatusDTO
    {
        $this->availableFunding = $availableFunding;
        return $this;
    }

    public function getAggregatorId(): string
    {
        return $this->aggregatorId;
    }

    public function setAggregatorId(string $aggregatorId): UserStatusDTO
    {
        $this->aggregatorId = $aggregatorId;

        return $this;
    }

    public function getBorrowerExternalId(): string
    {
        return $this->borrowerExternalId;
    }

    public function setBorrowerExternalId(string $borrowerExternalId): UserStatusDTO
    {
        $this->borrowerExternalId = $borrowerExternalId;

        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'aggregatorId' => $this->getAggregatorId(),
            'borrowerExternalId' => $this->getBorrowerExternalId(),
        ];
    }

    public static function fromResponseData(array $data): static
    {
        return (new static())
            ->setCode($data['code'])
            ->setDescription($data['description'])
            ->setUpdated($data['updated'])
            ->setFundingLimit($data['fundingLimit'])
            ->setAvailableFunding($data['availableFunding']);
    }
}
