<?php

declare(strict_types=1);

namespace App\Tests\Unit\Registry;

use App\Model\ShippingProvider\Omniva;
use App\Model\ShippingProvider\ShippingProviderInterface as ShippingProviderModelInterface;
use App\Model\ShippingProvider\UPS;
use App\Registry\ShippingProvider as ShippingProviderRegistry;
use Exception;
use PHPUnit\Framework\TestCase;

class ShippingProviderTest extends TestCase
{
    /**
     * @test
     * @dataProvider shouldReturnShippingProviderDataProvider
     *
     * @param array $shippingProviders
     * @param string $key
     * @param ShippingProviderModelInterface $expectedReturn
     */
    public function shouldReturnShippingProvider(
        array $shippingProviders,
        string $key,
        ShippingProviderModelInterface $expectedReturn
    ): void {
        $registry = new ShippingProviderRegistry($shippingProviders);

        $this->assertEquals($expectedReturn, $registry->getShippingProvider($key));
    }

    /**
     * @return array
     */
    public function shouldReturnShippingProviderDataProvider(): array
    {
        $shippingProviderUps = $this->createMock(UPS::class);
        $shippingProviderOmniva = $this->createMock(Omniva::class);

        $keyUps = 'ups';
        $keyOmniva = 'omniva';

        $shippingProviders = [
            $keyUps => $shippingProviderUps,
            $keyOmniva => $shippingProviderOmniva
        ];

        return [
            'ups' => [
                $shippingProviders,
                $keyUps,
                $shippingProviderUps
            ],
            'omniva' => [
                $shippingProviders,
                $keyOmniva,
                $shippingProviderOmniva
            ]
        ];
    }

    /**
     * @test
     * @dataProvider shouldThrowExceptionDataProvider
     *
     * @param array $shippingProviders
     * @param string $key
     */
    public function shouldThrowException(
        array $shippingProviders,
        string $key
    ): void {
        $registry = new ShippingProviderRegistry($shippingProviders);

        $this->expectException(Exception::class);

        $registry->getShippingProvider($key);
    }

    /**
     * @return array
     */
    public function shouldThrowExceptionDataProvider(): array
    {
        $shippingProviderUps = $this->createMock(UPS::class);
        $shippingProviderOmniva = $this->createMock(Omniva::class);

        $keyUps = 'ups';
        $keyOmniva = 'omniva';

        return [
            'missing ups' => [
                [$keyOmniva => $shippingProviderOmniva],
                $keyUps
            ],
            'missing omniva' => [
                [$keyUps => $shippingProviderUps],
                $keyOmniva
            ],
            'empty provider list' => [
                [],
                $keyUps
            ],
            'invalid key' => [
                [
                    $keyUps => $shippingProviderUps,
                    $keyOmniva => $shippingProviderOmniva
                ],
                'nonExistentKey'
            ],
        ];
    }
}
