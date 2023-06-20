<?php

namespace Ofload\Butn\Actions;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Ofload\Butn\ApplicationConstants;
use Ofload\Butn\DTO\AccessTokenDTO;
use Ofload\Butn\DTO\UserStatusDTO;
use Ofload\Butn\Exceptions\ButnServerException;

class CheckBorrowerStatusAction extends BaseAction
{
    public function __construct(
        private readonly HttpClient $httpClient,
        private readonly AccessTokenDTO $accessToken,
        private readonly UserStatusDTO $userStatusDTO
    ) {

    }

    public function execute(): UserStatusDTO
    {
        try {
            $response = $this->httpClient->post(
                $this->accessToken->getInstanceUrl() . ApplicationConstants::buildCheckUserStatusUri(),
                [
                    RequestOptions::HEADERS => [
                        'Authorization' => 'Bearer ' . $this->accessToken->getToken(),
                    ],
                    RequestOptions::JSON => $this->userStatusDTO->jsonSerialize()
                ]
            );

            $payload = json_decode($response->getBody()->getContents(), true);

            return UserStatusDTO::fromResponseData($payload);
        } catch (ClientException $exception) {
            $this->throwButnClientException($exception);
        } catch (GuzzleException $exception) {
            throw new ButnServerException(
                sprintf('Server error: failed to fetch user status %s', $this->userStatusDTO->getBorrowerExternalId()),
                $exception->getCode()
            );
        }
    }
}
