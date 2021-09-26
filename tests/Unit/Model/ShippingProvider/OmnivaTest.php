<?php

declare(strict_types=1);

namespace App\Tests\Unit\Model\ShippingProvider;

use App\Entity\Order as OrderEntity;
use App\Model\DataExtractor\Request\Omniva\Find as FindDataExtractor;
use App\Model\DataExtractor\Request\Omniva\Register as RegisterDataExtractor;
use App\Model\DataExtractor\Request\Omniva\Register as RequestOmnivaRegisterDataExtractor;
use App\Model\Mock\HttpClient\HttpClientInterface;
use App\Model\Mock\HttpClient\Omniva as OmnivaHttpClient;
use App\Model\Mock\HttpClient\Response\Omniva\Find as ResponseMockFind;
use App\Model\Mock\HttpClient\Response\Omniva\Register as ResponseMockRegister;
use App\Model\ShippingProvider\Omniva as OmnivaShippingProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\ResponseInterface;

class OmnivaTest extends TestCase
{
    /**
     * @test
     * @dataProvider notifyDataProvider
     *
     * @param array $extractedDataFromFind
     * @param array $extractedDataFromRegister
     * @param ResponseInterface $findHttpClientResponse
     * @param array $registerDataExtractorAdditionalData
     */
    public function notify(
        array $extractedDataFromFind,
        array $extractedDataFromRegister,
        ResponseInterface $findHttpClientResponse,
        array $registerDataExtractorAdditionalData
    ): void {
        $orderMock = $this->createMock(OrderEntity::class);

        $findDataExtractorMock = $this->createMock(FindDataExtractor::class);
        $findDataExtractorMock->method('extract')->with($orderMock)->willReturn($extractedDataFromFind);

        $httpClientMock = $this->createMock(OmnivaHttpClient::class);
        $httpClientMock
            ->expects($this->at(0))
            ->method('request')
            ->with(
                HttpClientInterface::METHOD_POST,
                OmnivaShippingProvider::URL_FIND,
                $extractedDataFromFind
            )->willReturn($findHttpClientResponse);

        $registerDataExtractorMock = $this->createMock(RegisterDataExtractor::class);
        $registerDataExtractorMock
            ->method('extract')
            ->with($orderMock, $registerDataExtractorAdditionalData)
            ->willReturn($extractedDataFromRegister);

        $httpClientMock
            ->expects($this->at(1))
            ->method('request')
            ->with(
                HttpClientInterface::METHOD_POST,
                OmnivaShippingProvider::URL_REGISTER,
                $extractedDataFromRegister
            )->willReturn($this->createMock(ResponseMockRegister::class));

        $shippingProvider = new OmnivaShippingProvider(
            $httpClientMock,
            $findDataExtractorMock,
            $registerDataExtractorMock
        );

        $shippingProvider->notify($orderMock);
    }

    /**
     * @return array
     */
    public function notifyDataProvider(): array
    {
        $content1 = '15';
        $responseMock1 = $this->createMock(ResponseMockFind::class);
        $responseMock1->method('getContent')->willReturn($content1);

        $content2 = 'qsedcasfae';
        $responseMock2 = $this->createMock(ResponseMockFind::class);
        $responseMock2->method('getContent')->willReturn($content2);

        return [
            [
                ['asd', 'qwe'],
                [1463456 => true],
                $responseMock1,
                [RequestOmnivaRegisterDataExtractor::KEY_PICKUP_POINT_ID => $content1]
            ],
            [
                [null],
                [124],
                $responseMock2,
                [RequestOmnivaRegisterDataExtractor::KEY_PICKUP_POINT_ID => $content2]
            ],
        ];
    }
}