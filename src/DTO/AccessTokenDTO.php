<?php

namespace Ofload\Butn\DTO;

class AccessTokenDTO
{
    private string $token;
    private string $scope;
    private string $instanceUrl;
    private string $id;
    private string $tokenType;

    public function fromArray(array $data): static
    {
        $this->setToken($data['access_token']);
        $this->setScope($data['scope']);
        $this->setInstanceUrl($data['instance_url']);
        $this->setId($data['id']);
        $this->setTokenType($data['token_type']);

        return $this;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function setToken(string $accessToken): void
    {
        $this->token = $accessToken;
    }

    public function getScope(): string
    {
        return $this->scope;
    }

    public function setScope(string $scope): void
    {
        $this->scope = $scope;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getTokenType(): string
    {
        return $this->tokenType;
    }

    public function setTokenType(string $tokenType): void
    {
        $this->tokenType = $tokenType;
    }

    public function getInstanceUrl(): string
    {
        return $this->instanceUrl;
    }

    public function setInstanceUrl(string $instanceUrl): void
    {
        $this->instanceUrl = $instanceUrl;
    }
}