<?php

namespace Ofload\Butn\DTO;

class TransactionStatusDTO implements \JsonSerializable
{
    private string $aggregatorId;
    private string $transactionId;

    public function getAggregatorId(): string
    {
        return $this->aggregatorId;
    }

    public function setAggregatorId(string $aggregatorId): TransactionStatusDTO
    {
        $this->aggregatorId = $aggregatorId;
        return $this;
    }

    public function getTransactionId(): string
    {
        return $this->transactionId;
    }

    public function setTransactionId(string $transactionId): TransactionStatusDTO
    {
        $this->transactionId = $transactionId;
        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'aggregatorId' => $this->getAggregatorId(),
            'transactionId' => $this->getTransactionId()
        ];
    }
}
