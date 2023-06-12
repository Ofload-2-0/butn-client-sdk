<?php

namespace Ofload\Butn\Actions;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Ofload\Butn\ApplicationConstants;
use Ofload\Butn\DTO\AccessTokenDTO;
use Ofload\Butn\DTO\UserDTO;
use Ofload\Butn\DTO\UserResponseDTO;
use Ofload\Butn\Exceptions\ButnServerException;

class RegisterUserAction extends BaseAction
{
    public function __construct(
        private readonly HttpClient $httpClient,
        private readonly AccessTokenDTO $accessToken,
        private readonly UserDTO $userDTO
    ) {

    }

    public function execute(): UserResponseDTO
    {
        try {
            $response = $this->httpClient->post(
                $this->accessToken->getInstanceUrl() . ApplicationConstants::buildRegisterUserUri(),
                [
                    RequestOptions::HEADERS => [
                        'Authorization' => 'Bearer ' . $this->accessToken->getToken(),
                    ],
                    RequestOptions::JSON => $this->userDTO->jsonSerialize()
                ]
            );

            $payload = json_decode($response->getBody()->getContents(), true);

            return UserResponseDTO::fromArray($payload);
        } catch (ClientException $exception) {
            $this->throwButnClientException($exception);
        } catch (GuzzleException $exception) {
            throw new ButnServerException(
                sprintf('Server error: failed to process transaction %s', $this->userDTO->getEmail()),
                $exception->getCode()
            );
        }
    }
}
