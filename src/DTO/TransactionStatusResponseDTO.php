<?php

namespace Ofload\Butn\DTO;

use DateTime;
use Exception;
use JsonMapper;
use JsonMapper_Exception;

class TransactionStatusResponseDTO
{
    private string $code;
    private string $description;
    private DateTime $updated;
    private ?DateTime $dueDate = null;
    private ?float $amountFunded = null;
    private ?float $fundingFee = null;
    private ?float $establishmentFee = null;
    private ?float $lateFees = null;
    private ?float $adhocFees = null;

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): TransactionStatusResponseDTO
    {
        $this->code = $code;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): TransactionStatusResponseDTO
    {
        $this->description = $description;
        return $this;
    }

    public function getUpdated(): DateTime
    {
        return $this->updated;
    }

    /**
     * @throws Exception
     */
    public function setUpdated(?string $updated): TransactionStatusResponseDTO
    {
        $this->updated = $updated ? new DateTime($updated) : null;
        return $this;
    }

    public function getDueDate(): ?DateTime
    {
        return $this->dueDate;
    }

    /**
     * @throws Exception
     */
    public function setDueDate(?string $dueDate): TransactionStatusResponseDTO
    {
        $this->dueDate = $dueDate ? new DateTime($dueDate) : $dueDate;
        return $this;
    }

    public function getAmountFunded(): ?float
    {
        return $this->amountFunded;
    }

    public function setAmountFunded(string $amountFunded): TransactionStatusResponseDTO
    {
        $this->amountFunded = $amountFunded;
        return $this;
    }

    public function getFundingFee(): ?float
    {
        return $this->fundingFee;
    }

    public function setFundingFee(string $fundingFee): TransactionStatusResponseDTO
    {
        $this->fundingFee = $fundingFee;
        return $this;
    }

    public function getEstablishmentFee(): ?float
    {
        return $this->establishmentFee;
    }

    public function setEstablishmentFee(string $establishmentFee): TransactionStatusResponseDTO
    {
        $this->establishmentFee = $establishmentFee;
        return $this;
    }

    public function getLateFees(): ?float
    {
        return $this->lateFees;
    }

    public function setLateFees(string $lateFees): TransactionStatusResponseDTO
    {
        $this->lateFees = $lateFees;
        return $this;
    }

    public function getAdhocFees(): ?float
    {
        return $this->adhocFees;
    }

    public function setAdhocFees(string $adhocFees): TransactionStatusResponseDTO
    {
        $this->adhocFees = $adhocFees;
        return $this;
    }

    /**
     * @throws JsonMapper_Exception
     */
    public static function fromJson(object $json): static
    {
        $mapper = new JsonMapper();
        $mapper->bStrictNullTypes = false;
        $mapper->bExceptionOnUndefinedProperty = false;

        return $mapper->map($json, new static());
    }
}
