<?php

namespace Unit;

use DateTime;
use DateTimeInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Ofload\Butn\Client as OfloadButnClient;
use GuzzleHttp\Client as HttpClient;
use Ofload\Butn\DTO\AccessTokenDTO;
use Ofload\Butn\DTO\CounterPartyDTO;
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
    private const COUNTER_PARTY_ABN = '123456789';
    private const COUNTER_PARTY_NAME = 'Acme Corp';

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

    public function testItShouldGetTransactionStatusWithoutFundingDetails(): void
    {
        $transactionID = 'foo-bar';
        $accessTokenDto = (new AccessTokenDTO())
            ->fromArray(self::ACCESS_TOKEN_DATA);
        $transactionStatus = (new TransactionStatusDTO())
            ->setAggregatorId('test')
            ->setTransactionId($transactionID);

        $this->createSuccessResponseFrom([
            'code' => 'Review',
            'description' => 'Aggregator Setting - All new transactions are under review',
            'updated' => '2023-07-21T02:35:25Z'
        ]);

        $response = $this->createButnClient()->checkTransactionStatus($transactionStatus, $accessTokenDto);
        $this->assertEquals('Review', $response->getCode());
        $this->assertEquals('Aggregator Setting - All new transactions are under review', $response->getDescription());
        $this->assertEquals('2023-07-21T02:35:25+00:00', $response->getUpdated()->format(DateTimeInterface::ATOM));
        $this->assertNull($response->getFundingFee());
        $this->assertNull($response->getDueDate());
        $this->assertNull($response->getAmountFunded());
        $this->assertNull($response->getEstablishmentFee());
        $this->assertNull($response->getLateFees());
        $this->assertNull($response->getAdhocFees());
    }

    public function testItShouldGetTransactionStatusWithFundingDetails(): void
    {
        $transactionID = 'foo-bar';
        $accessTokenDto = (new AccessTokenDTO())
            ->fromArray(self::ACCESS_TOKEN_DATA);
        $transactionStatus = (new TransactionStatusDTO())
            ->setAggregatorId('test')
            ->setTransactionId($transactionID);

        $this->createSuccessResponseFrom([
            "updated" => "2022-03-09T04:19:33Z",
            "description" => "Transaction is currently active and is being serviced",
            "fundingFee" => "19.22",
            "dueDate" => "2022-04-08T00:00:00Z",
            "amountFunded" => "1202.00",
            "code" => "Active"
        ]);

        $response = $this->createButnClient()->checkTransactionStatus($transactionStatus, $accessTokenDto);
        $this->assertEquals('Active', $response->getCode());
        $this->assertEquals('Transaction is currently active and is being serviced', $response->getDescription());
        $this->assertEquals('2022-03-09T04:19:33+00:00', $response->getUpdated()->format(DateTimeInterface::ATOM));
        $this->assertEquals(19.22, $response->getFundingFee());
        $this->assertEquals('2022-04-08T00:00:00+00:00', $response->getDueDate()->format(DateTimeInterface::ATOM));
        $this->assertEquals(1202.00, $response->getAmountFunded());
    }

    public function dataProviderCounterParty(): \Generator
    {
        yield 'Without Counter Party' => [null];
        yield 'Counter Party with only ABN' => [new CounterPartyDTO(self::COUNTER_PARTY_ABN)];
        yield 'Counter Party with ABN and Name' => [(new CounterPartyDTO(self::COUNTER_PARTY_ABN))->setName(self::COUNTER_PARTY_NAME)];
    }

    /**
     * @dataProvider dataProviderCounterParty
     */
    public function testShouldHaveCounterPartyInTransactionPayload($counterParty): void
    {
        $mockHandler = new MockHandler([
            function (Request $request) use ($counterParty) {
                $payload = json_decode($request->getBody()->getContents(), true);
                if (is_null($counterParty)) {
                    $this->assertArrayNotHasKey('counterParty', $payload);
                    return new Response(200, [], json_encode(['payloadId' => 'FOO']));
                }

                $this->assertArrayHasKey('counterParty', $payload);
                $this->assertEquals(self::COUNTER_PARTY_ABN, $payload['counterParty']['counterPartyABN']);

                if (is_null($counterParty->getName())) {
                    $this->assertArrayNotHasKey('counterPartyName', $payload['counterParty']);
                    return new Response(200, [], json_encode(['payloadId' => 'FOO']));
                }

                $this->assertEquals(self::COUNTER_PARTY_NAME, $payload['counterParty']['counterPartyName']);
                return new Response(200, [], json_encode(['payloadId' => 'FOO']));
            }
        ]);
        $handler = HandlerStack::create($mockHandler);
        $this->httpClient = new HttpClient(['handler' => $handler]);

        $accessTokenDto = (new AccessTokenDTO())
            ->fromArray(self::ACCESS_TOKEN_DATA);

        $transactionDto = (new TransactionDTO())
            ->setAggregatorId('test')
            ->setTransactionId('invoice-id')
            ->setBorrowerExternalId('borrower-id')
            ->setButnProductType('Butn Pay')
            ->setFactorFaceValue('100')
            ->setDebtorEmail('debtor@example.com')
            ->setPotBase64BinaryStream('pot-base64-binary-stream')
            ->setCounterParty($counterParty);

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

        $this->httpClient->expects($this->any())
            ->method('post')
            ->willReturn($response);

        $this->httpClient->expects($this->any())
            ->method('get')
            ->willReturn($response);

        return $response;
    }
}
