<?php

namespace Unit;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use http\Env\Request;
use Ofload\Butn\Client as OfloadButnClient;
use GuzzleHttp\Client as HttpClient;
use Ofload\Butn\DTO\AccessTokenDTO;
use Ofload\Butn\DTO\TransactionDTO;
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
        $transactionDto = (new TransactionDTO())
            ->setTransactionId('FOO BAR')
            ->setAggregatorId('FOO')
            ->setBorrowerExternalId('BAR')
            ->setFactorFaceValue(1000)
            ->setDebtorEmail('foo@bar.com')
            ->setPotBase64BinaryStream('');

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
            ->setTransactionId($transactionId)
            ->setAggregatorId('FOO')
            ->setBorrowerExternalId('BAR')
            ->setFactorFaceValue(1000)
            ->setDebtorEmail('foo@bar.com')
            ->setPotBase64BinaryStream('');

        $this->createButnClient()->createTransaction($transactionDto, $accessTokenDto);
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

        $this->httpClient->expects($this->atLeastOnce())
            ->method('post')
            ->willReturn($response);

        return $response;
    }
}
