<?php

declare(strict_types=1);

namespace Ofload\Butn;

use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Ofload\Butn\Exceptions\ButnClientException;
use Ofload\Butn\Exceptions\ButnServerException;
use Ofload\Butn\DTO\AccessTokenDTO;
use Ofload\Butn\DTO\TransactionDTO;

class Client
{
    public function __construct(
        private readonly string $oauthToken,
        private readonly GuzzleHttpClient $httpClient,
        private string $mode = ApplicationConstants::SANDBOX_APPLICATION_MODE
    ) {
    }

    /**
     * @throws ButnServerException|ButnClientException
     */
    public function createTransaction(TransactionDTO $request, AccessTokenDTO $accessToken = null): string
    {
        if (is_null($accessToken)) {
            $accessToken = $this->getAccessToken();
        }

        try {
            $response = $this->httpClient->post(
                $accessToken->getInstanceUrl() . ApplicationConstants::TRANSACTION_OPTIN_V1_URI,
                [
                    RequestOptions::HEADERS => [
                        'Authorization' => 'Bearer ' . $accessToken->getToken(),
                    ],
                    RequestOptions::JSON => $request
                ]
            );

            $payload = json_decode($response->getBody()->getContents());

            return $payload->payloadId;
        } catch (ClientException $exception) {
            $this->throwButnClientException($exception);
        } catch (GuzzleException $exception) {
            throw new ButnServerException(
                sprintf('Server error: failed to process transaction %s', $request->getTransactionId()),
                $exception->getCode()
            );
        }
    }

    public function getAccessToken(): AccessTokenDTO
    {
        try {
            $rawResponse = $this->httpClient->post(
                $this->getUrl() . ApplicationConstants::TOKEN_URI,
                [
                    RequestOptions::FORM_PARAMS => [
                        'grant_type' => ApplicationConstants::JWT_GRANT_TYPE,
                        'assertion' => $this->oauthToken,
                    ],
                ]
            );

            $accessToken = json_decode($rawResponse->getBody()->getContents(), associative: true);
            return (new AccessTokenDTO())
                ->fromArray($accessToken);
        } catch (ClientException $exception) {
            $this->throwButnClientException($exception);
        }
    }

    public function enableProductionMode(): static
    {
        $this->mode = ApplicationConstants::PRODUCTION_APPLICATION_MODE;

        return $this;
    }

    public function getUrl(): string
    {
        if ($this->mode === ApplicationConstants::SANDBOX_APPLICATION_MODE) {
            return ApplicationConstants::SANDBOX_URL;
        };

        return ApplicationConstants::PRODUCTION_URL;
    }

    /**
     * @throws ButnClientException
     */
    private function throwButnClientException(ClientException $exception): void
    {
        $error = json_decode($exception->getResponse()->getBody()->getContents());
        $errorMessage = $error->error_description ?? $error->description ?? $exception->getMessage();
        throw new ButnClientException($errorMessage, $exception->getCode());
    }
}