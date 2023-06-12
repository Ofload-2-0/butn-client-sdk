<?php

namespace Ofload\Butn\DTO;

use JsonSerializable;

class BankAccountDTO implements JsonSerializable
{
    private string $accountName;
    private string $bsb;
    private string $accountNumber;

    public function getAccountName(): string
    {
        return $this->accountName;
    }

    public function setAccountName(string $accountName): BankAccountDTO
    {
        $this->accountName = $accountName;
        return $this;
    }

    public function getBsb(): string
    {
        return $this->bsb;
    }

    public function setBsb(string $bsb): BankAccountDTO
    {
        $this->bsb = $bsb;
        return $this;
    }

    public function getAccountNumber(): string
    {
        return $this->accountNumber;
    }

    public function setAccountNumber(string $accountNumber): BankAccountDTO
    {
        $this->accountNumber = $accountNumber;
        return $this;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'accountName' => $this->getAccountName(),
            'BSB' => $this->getBsb(),
            'accountNumber' => $this->getAccountNumber()
        ];
    }
}
