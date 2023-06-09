<?php

namespace Ofload\Butn\DTO;

class UserResponseDTO
{
    private string $redirectUri;
    private string $borrowerPayloadId;

    public function getRedirectUri(): string
    {
        return $this->redirectUri;
    }

    public function setRedirectUri(string $redirectUri): UserResponseDTO
    {
        $this->redirectUri = $redirectUri;
        return $this;
    }

    public function getBorrowerPayloadId(): string
    {
        return $this->borrowerPayloadId;
    }

    public function setBorrowerPayloadId(string $borrowerPayloadId): UserResponseDTO
    {
        $this->borrowerPayloadId = $borrowerPayloadId;
        return $this;
    }

    public static function fromArray(array $data): static
    {
        return (new static())
            ->setBorrowerPayloadId($data['borrowerPayloadId'])
            ->setRedirectUri($data['redirectUri']);
    }
}
