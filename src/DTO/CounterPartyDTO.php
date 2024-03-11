<?php

namespace Ofload\Butn\DTO;

use JsonSerializable;

class CounterPartyDTO implements JsonSerializable
{
    private ?string $name = null;
    private string $abn;

    public function __construct(string $abn)
    {
        $this->abn = $abn;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): CounterPartyDTO
    {
        $this->name = $name;
        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'counterPartyABN' => $this->abn,
            ...($this->name
                ? ['counterPartyName' => $this->name]
                : [])
        ];
    }
}
