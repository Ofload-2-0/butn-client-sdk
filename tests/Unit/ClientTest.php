<?php

namespace Unit;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use http\Env\Request;
use Ofload\Butn\Client as OfloadButnClient;
use GuzzleHttp\Client as HttpClient;
use Ofload\Butn\DTO\AccessTokenDTO;
use Ofload\Butn\DTO\TransactionDTO;
use Ofload\Butn\DTO\TransactionStatusDTO;
use Ofload\Butn\DTO\UserDTO;
use Ofload\Butn\DTO\UserStatusDTO;
use Ofload\Butn\Exceptions\ButnServerException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Ofload\Butn\Exceptions\ButnClientException;

class ClientTest extends \PHPUnit\Framework\TestCase
{
    private const ACCESS_TOKEN_DATA = [
        'access_token' => 'FOO',
        'scope' => 'BAR',
        'instance_url' => 'foo.com',
        'id' => 'TEST-ID',
        'token_type' => 'TEST-TOKEN'
    ];
    private const OAUTH_TOKEN = 'test-token';

    private HttpClient $httpClient;

    protected function setUp(): void
    {
        parent::setUp();

        $this->httpClient = $this->createMock(HttpClient::class);
    }

    public function testShouldGetAccessToken(): void
    {
        $this->createSuccessResponseFrom(self::ACCESS_TOKEN_DATA);

        $accessToken = $this->createButnClient()->getAccessToken();

        $this->assertEquals(self::ACCESS_TOKEN_DATA['access_token'], $accessToken->getToken());
        $this->assertEquals(self::ACCESS_TOKEN_DATA['instance_url'], $accessToken->getInstanceUrl());
        $this->assertEquals(self::ACCESS_TOKEN_DATA['id'], $accessToken->getId());
        $this->assertEquals(self::ACCESS_TOKEN_DATA['scope'], $accessToken->getScope());
        $this->assertEquals(self::ACCESS_TOKEN_DATA['token_type'], $accessToken->getTokenType());
    }

    public function testThrowCustomClientButnException(): void
    {
        $this->expectException(ButnClientException::class);

        $response = $this->createFailedResponse();
        $request = $this->createMock(RequestInterface::class);
        $this->httpClient->method('post')
            ->willThrowException(new ClientException('FOO EXCEPTION', $request, $response));

        $this->createButnClient()->getAccessToken();
    }

    public function testShouldCreateTransaction(): void
    {
        $payloadId = 'FOO';
        $accessTokenDto = (new AccessTokenDTO())
            ->fromArray(self::ACCESS_TOKEN_DATA);
        $transactionDto = new TransactionDTO();

        $this->createSuccessResponseFrom(['payloadId' => $payloadId]);

        $responsePayloadId = $this->createButnClient()->createTransaction($transactionDto, $accessTokenDto);

        $this->assertEquals($payloadId, $responsePayloadId);
    }

    public function testShouldThrowButnServerExceptionOnGuzzleException(): void
    {
        $this->expectException(ButnServerException::class);
        $transactionId = 'FOO-TRANSACTION';

        $guzzleException = $this->createMock(GuzzleException::class);
        $this->httpClient->method('post')
            ->willThrowException($guzzleException);
        $accessTokenDto = (new AccessTokenDTO())
            ->fromArray(self::ACCESS_TOKEN_DATA);
        $transactionDto = (new TransactionDTO())
            ->setTransactionId($transactionId);

        $this->createButnClient()->createTransaction($transactionDto, $accessTokenDto);
    }

    public function testShouldItShouldRegisterUser(): void
    {
        $redirectUri = 'redirect-uri';
        $borrowerPayloadId = 'borrower-payload';
        $accessTokenDto = (new AccessTokenDTO())
            ->fromArray(self::ACCESS_TOKEN_DATA);
        $userDTO = (new UserDTO())
            ->setAggregatorId('foo')
            ->setBorrowerExternalId('foo')
            ->setAbn('foo')
            ->setProductType('bar');

        $this->createSuccessResponseFrom([
            'redirectUri' => $redirectUri,
            'borrowerPayloadId' => $borrowerPayloadId
        ]);

        $response = $this->createButnClient()->registerUser($userDTO, $accessTokenDto);

        $this->assertEquals($redirectUri, $response->getRedirectUri());
        $this->assertEquals($borrowerPayloadId, $response->getBorrowerPayloadId());
    }

    public function testItShouldGetBorrowerDetails(): void
    {
        $externalBorrowerID = 'foo-bar';
        $accessTokenDto = (new AccessTokenDTO())
            ->fromArray(self::ACCESS_TOKEN_DATA);
        $userStatusDTO = (new UserStatusDTO())
            ->setAggregatorId('test')
            ->setBorrowerExternalId($externalBorrowerID);

        $this->createSuccessResponseFrom([
            'description' => 'foo',
            'code' => 'bar',
            'updated' => 'test',
            'fundingLimit' => 111,
            'availableFunding' => 111,
        ]);

        $response = $this->createButnClient()->checkBorrowerStatus($userStatusDTO, $accessTokenDto);

        $this->assertNotEmpty($response->getCode());
        $this->assertNotEmpty($response->getDescription());
        $this->assertNotEmpty($response->getFundingLimit());
        $this->assertNotEmpty($response->getAvailableFunding());
    }

    public function testItShouldGetTransactionStatus(): void
    {
        $transactionID = 'foo-bar';
        $accessTokenDto = (new AccessTokenDTO())
            ->fromArray(self::ACCESS_TOKEN_DATA);
        $transactionStatus = (new TransactionStatusDTO())
            ->setAggregatorId('test')
            ->setTransactionId($transactionID);

        $this->createSuccessResponseFrom([
            'code' => 'foo',
            'description' => 'bar',
            'updated' => 'test',
            'dueDate' => (new \DateTime())->format('YYYY-MM-DDTHH:mm:ss.sssZ'),
            'amountFunded' => 111,
            'fundingFee' => 111,
            'establishmentFee' => 111,
            'lateFees' => 111,
            'adhocFees' => 111,
        ]);

        $response = $this->createButnClient()->checkTransactionStatus($transactionStatus, $accessTokenDto);

        $this->assertNotEmpty($response->getCode());
        $this->assertNotEmpty($response->getDescription());
        $this->assertNotEmpty($response->getAdhocFees());
        $this->assertNotEmpty($response->getAmountFunded());
        $this->assertNotEmpty($response->getEstablishmentFee());
        $this->assertNotEmpty($response->getLateFees());
        $this->assertNotEmpty($response->getFundingFee());
        $this->assertNotEmpty($response->getDueDate());
    }

    private function createButnClient(): OfloadButnClient
    {
        return new OfloadButnClient(self::OAUTH_TOKEN, $this->httpClient);
    }

    private function createSuccessResponseFrom(array $data): ResponseInterface
    {
        $stream = $this->createMock(StreamInterface::class);
        $stream->expects($this->atLeastOnce())
            ->method('getContents')
            ->willReturn(json_encode($data));

        return $this->createStreamResponse($stream);
    }

    private function createFailedResponse(): ResponseInterface
    {
        $stream = $this->createMock(StreamInterface::class);
        $stream->expects($this->atLeastOnce())
            ->method('getContents')
            ->willReturn(json_encode(['error_description' => 'FOO EXCEPTION']));

        return $this->createStreamResponse($stream);
    }

    private function createStreamResponse(StreamInterface $stream): ResponseInterface
    {
        $response = $this->createMock(ResponseInterface::class);
        $response->expects($this->atLeastOnce())
            ->method('getBody')
            ->willReturn($stream);

        $this->httpClient->expects($this->any())
            ->method('post')
            ->willReturn($response);

        $this->httpClient->expects($this->any())
            ->method('get')
            ->willReturn($response);

        return $response;
    }
}
