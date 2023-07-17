<?php

namespace Ofload\Butn\DTO;

class TransactionStatusResponseDTO
{
    private string $code;
    private string $description;
    private string $updated;
    private string $dueDate;
    private string $amountFunded;
    private string $fundingFee;
    private string $establishmentFee;
    private string $lateFees;
    private string $adhocFees;

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

    public function getUpdated(): string
    {
        return $this->updated;
    }

    public function setUpdated(string $updated): TransactionStatusResponseDTO
    {
        $this->updated = $updated;
        return $this;
    }

    public function getDueDate(): string
    {
        return $this->dueDate;
    }

    public function setDueDate(string $dueDate): TransactionStatusResponseDTO
    {
        $this->dueDate = $dueDate;
        return $this;
    }

    public function getAmountFunded(): string
    {
        return $this->amountFunded;
    }

    public function setAmountFunded(string $amountFunded): TransactionStatusResponseDTO
    {
        $this->amountFunded = $amountFunded;
        return $this;
    }

    public function getFundingFee(): string
    {
        return $this->fundingFee;
    }

    public function setFundingFee(string $fundingFee): TransactionStatusResponseDTO
    {
        $this->fundingFee = $fundingFee;
        return $this;
    }

    public function getEstablishmentFee(): string
    {
        return $this->establishmentFee;
    }

    public function setEstablishmentFee(string $establishmentFee): TransactionStatusResponseDTO
    {
        $this->establishmentFee = $establishmentFee;
        return $this;
    }

    public function getLateFees(): string
    {
        return $this->lateFees;
    }

    public function setLateFees(string $lateFees): TransactionStatusResponseDTO
    {
        $this->lateFees = $lateFees;
        return $this;
    }

    public function getAdhocFees(): string
    {
        return $this->adhocFees;
    }

    public function setAdhocFees(string $adhocFees): TransactionStatusResponseDTO
    {
        $this->adhocFees = $adhocFees;
        return $this;
    }

    public static function fromArray(array $data): static
    {
        return (new static())
            ->setCode($data['code'])
            ->setDescription($data['description'])
            ->setUpdated($data['updated'])
            ->setDueDate($data['dueDate'])
            ->setAmountFunded($data['amountFunded'])
            ->setFundingFee($data['fundingFee'])
            ->setEstablishmentFee($data['establishmentFee'])
            ->setLateFees($data['lateFees'])
            ->setAdhocFees($data['adhocFees']);
    }
}
