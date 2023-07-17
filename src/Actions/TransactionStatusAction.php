<?php

namespace Ofload\Butn\Actions;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Ofload\Butn\ApplicationConstants;
use Ofload\Butn\DTO\AccessTokenDTO;
use Ofload\Butn\DTO\TransactionStatusDTO;
use Ofload\Butn\DTO\TransactionStatusResponseDTO;
use Ofload\Butn\Exceptions\ButnServerException;

class TransactionStatusAction extends BaseAction
{
    public function __construct(
        private readonly HttpClient $httpClient,
        private readonly AccessTokenDTO $accessToken,
        private readonly TransactionStatusDTO $transactionStatusRequestDTO
    ) {
    }

    public function execute(): TransactionStatusResponseDTO
    {
        try {
            $queryParams = http_build_query($this->transactionStatusRequestDTO->jsonSerialize());
            $url = $this->accessToken->getInstanceUrl() . ApplicationConstants::buildCheckTransactionStatusUri();

            $response = $this->httpClient->get(
                sprintf('%s?%', $url, $queryParams),
                [
                    RequestOptions::HEADERS => [
                        'Authorization' => 'Bearer ' . $this->accessToken->getToken(),
                        'accept' => 'application/json'
                    ],
                ]
            );

            $payload = json_decode($response->getBody()->getContents(), true);

            return TransactionStatusResponseDTO::fromArray($payload);
        } catch (ClientException $exception) {
            $this->throwButnClientException($exception);
        } catch (GuzzleException $exception) {
            throw new ButnServerException(
                sprintf('Server error: failed to fetch transaction %s', $this->transactionStatusRequestDTO->getTransactionId()),
                $exception->getCode()
            );
        }
    }
}
