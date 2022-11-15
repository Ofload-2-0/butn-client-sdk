<?php

namespace Ofload\Butn\DTO;

use JsonSerializable;
use Ofload\Butn\ApplicationConstants;
use Ofload\Butn\Enums\InstallmentFrequency;
use Ofload\Butn\Enums\PotTypes;

class TransactionDTO implements JsonSerializable
{
    private string $transactionId;
    private string $aggregatorId;
    private string $borrowerExternalId;
    private string $butnProductType = ApplicationConstants::BUTTON_PAY;
    private string $debtorEmail;
    private float $factorFaceValue;
    private string $potBase64BinaryStream;
    private ?string $dueDate = null;
    private ?string $potReference = null;
    private ?string $debtorABN = null;
    private ?string $debtorPhone = null;
    private ?string $debtorName = null;
    private ?string $paymentsOutBsb = null;
    private ?string $paymentsOutBankAccount = null;
    private ?string $paymentsOutBankAccountName = null;
    private ?string $potExt = null;
    private ?PotTypes $potType = null;
    private ?InstallmentFrequency $installmentFrequency = null;
    private ?string $numberOfInstalments = null;
    private ?string $rateId = null;

    public function getTransactionId(): string
    {
        return $this->transactionId;
    }

    public function setTransactionId(string $transactionId): TransactionDTO
    {
        $this->transactionId = $transactionId;

        return $this;
    }

    public function getAggregatorId(): string
    {
        return $this->aggregatorId;
    }

    public function setAggregatorId(string $aggregatorId): TransactionDTO
    {
        $this->aggregatorId = $aggregatorId;

        return $this;
    }

    public function getBorrowerExternalId(): string
    {
        return $this->borrowerExternalId;
    }

    public function setBorrowerExternalId(string $borrowerExternalId): TransactionDTO
    {
        $this->borrowerExternalId = $borrowerExternalId;

        return $this;
    }

    public function getButnProductType(): string
    {
        return $this->butnProductType;
    }

    public function setButnProductType(string $butnProductType): TransactionDTO
    {
        $this->butnProductType = $butnProductType;

        return $this;
    }

    public function getDebtorEmail(): string
    {
        return $this->debtorEmail;
    }

    public function setDebtorEmail(string $debtorEmail): TransactionDTO
    {
        $this->debtorEmail = $debtorEmail;

        return $this;
    }

    public function getFactorFaceValue(): int
    {
        return $this->factorFaceValue;
    }

    public function setFactorFaceValue(int $factorFaceValue): TransactionDTO
    {
        $this->factorFaceValue = $factorFaceValue;

        return $this;
    }

    public function getPotBase64BinaryStream(): string
    {
        return $this->potBase64BinaryStream;
    }

    public function setPotBase64BinaryStream(string $potBase64BinaryStream): TransactionDTO
    {
        $this->potBase64BinaryStream = $potBase64BinaryStream;

        return $this;
    }

    public function getDueDate(): ?string
    {
        return $this->dueDate;
    }

    public function setDueDate(?string $dueDate): TransactionDTO
    {
        $this->dueDate = $dueDate;

        return $this;
    }

    public function getPotReference(): ?string
    {
        return $this->potReference;
    }

    public function setPotReference(?string $potReference): TransactionDTO
    {
        $this->potReference = $potReference;

        return $this;
    }

    public function getDebtorABN(): ?string
    {
        return $this->debtorABN;
    }

    public function setDebtorABN(?string $debtorABN): TransactionDTO
    {
        $this->debtorABN = $debtorABN;

        return $this;
    }

    public function getDebtorPhone(): ?string
    {
        return $this->debtorPhone;
    }

    public function setDebtorPhone(?string $debtorPhone): TransactionDTO
    {
        $this->debtorPhone = $debtorPhone;

        return $this;
    }

    public function getDebtorName(): ?string
    {
        return $this->debtorName;
    }

    public function setDebtorName(?string $debtorName): TransactionDTO
    {
        $this->debtorName = $debtorName;

        return $this;
    }

    public function getPaymentsOutBsb(): ?string
    {
        return $this->paymentsOutBsb;
    }

    public function setPaymentsOutBsb(?string $paymentsOutBsb): TransactionDTO
    {
        $this->paymentsOutBsb = $paymentsOutBsb;

        return $this;
    }

    public function getPaymentsOutBankAccount(): ?string
    {
        return $this->paymentsOutBankAccount;
    }

    public function setPaymentsOutBankAccount(?string $paymentsOutBankAccount): TransactionDTO
    {
        $this->paymentsOutBankAccount = $paymentsOutBankAccount;

        return $this;
    }

    public function getPaymentsOutBankAccountName(): ?string
    {
        return $this->paymentsOutBankAccountName;
    }

    public function setPaymentsOutBankAccountName(?string $paymentsOutBankAccountName): TransactionDTO
    {
        $this->paymentsOutBankAccountName = $paymentsOutBankAccountName;

        return $this;
    }

    public function getPotExt(): ?string
    {
        return $this->potExt;
    }

    public function setPotExt(?string $potExt): TransactionDTO
    {
        $this->potExt = $potExt;

        return $this;
    }

    public function getPotType(): ?PotTypes
    {
        return $this->potType;
    }

    public function setPotType(?PotTypes $potType): TransactionDTO
    {
        $this->potType = $potType;

        return $this;
    }

    public function getInstallmentFrequency(): ?InstallmentFrequency
    {
        return $this->installmentFrequency;
    }

    public function setInstallmentFrequency(?InstallmentFrequency $installmentFrequency): TransactionDTO
    {
        $this->installmentFrequency = $installmentFrequency;

        return $this;
    }

    public function getNumberOfInstalments(): ?string
    {
        return $this->numberOfInstalments;
    }

    public function setNumberOfInstalments(?string $numberOfInstalments): TransactionDTO
    {
        $this->numberOfInstalments = $numberOfInstalments;

        return $this;
    }

    public function getRateId(): ?string
    {
        return $this->rateId;
    }

    public function setRateId(?string $rateId): TransactionDTO
    {
        $this->rateId = $rateId;

        return $this;
    }

    public function jsonSerialize(): array
    {
        $data = [
            'aggregatorId' => $this->getAggregatorId(),
            'transactionId' => $this->getTransactionId(),
            'borrowerExternalId' => $this->getBorrowerExternalId(),
            'butnProductType' => $this->getButnProductType(),
            'factorFaceValue' => $this->getFactorFaceValue(),
            'debtorEmail' => $this->getDebtorEmail(),
            'potBase64BinaryStream' => $this->getPotBase64BinaryStream(),
        ];

        if ($this->getDebtorABN()) {
            $data['debtorABN'] = $this->getDebtorABN();
        }

        if ($this->getDebtorPhone()) {
            $data['debtorPhone'] = $this->getDebtorPhone();
        }

        if ($this->getDebtorName()) {
            $data['debtorName'] = $this->getDebtorName();
        }

        if ($this->getPaymentsOutBankAccount()) {
            $data['paymentsOutBankAccount'] = $this->getPaymentsOutBankAccount();
        }

        if ($this->getPaymentsOutBankAccountName()) {
            $data['paymentsOutBankAccountName'] = $this->getPaymentsOutBankAccountName();
        }

        if ($this->getPaymentsOutBsb()) {
            $data['paymentsOutBsb'] = $this->getPaymentsOutBsb();
        }

        if ($this->getPotReference()) {
            $data['potReference'] = $this->getPotReference();
        }

        if ($this->getPotType()) {
            $data['potType'] = $this->getPotType()->value;
        }

        if ($this->getPotExt()) {
            $data['potExt'] = $this->getPotExt();
        }

        if ($this->getInstallmentFrequency()) {
            $data['installmentFrequency'] = $this->getInstallmentFrequency()->value;
        }

        if ($this->getNumberOfInstalments()) {
            $data['numberOfInstalments'] = $this->getNumberOfInstalments();
        }

        if ($this->getDueDate()) {
            $data['dueDate'] = $this->getDueDate();
        }

        if ($this->getRateId()) {
            $data['rateId'] = $this->getRateId();
        }

        return $data;
    }
}