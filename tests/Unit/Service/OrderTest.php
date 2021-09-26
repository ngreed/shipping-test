<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service;

use App\Entity\Order as OrderEntity;
use App\Model\ShippingProvider\Omniva;
use App\Model\ShippingProvider\ShippingProviderInterface as ShippingProviderModelInterface;
use App\Model\ShippingProvider\UPS;
use App\Registry\ShippingProvider as ShippingProviderRegistry;
use App\Service\Order as OrderService;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    /**
     * @test
     * @dataProvider registerShippingDataProvider
     *
     * @param OrderEntity $order
     * @param string $providerKey
     * @param ShippingProviderModelInterface $shippingProvider
     */
    public function registerShipping(
        OrderEntity $order,
        string $providerKey,
        ShippingProviderModelInterface $shippingProvider
    ): void {
        $this->expectNotToPerformAssertions();

        $shippingProviderRegistryMock = $this->createMock(ShippingProviderRegistry::class);
        $shippingProviderRegistryMock
            ->method('getShippingProvider')
            ->with($providerKey)
            ->willReturn($shippingProvider);

        $orderService = new OrderService($shippingProviderRegistryMock);
        $orderService->registerShipping($order);
    }

    /**
     * @return array
     */
    public function registerShippingDataProvider(): array
    {
        $shippingProviderKeyUps = 'ups';
        $orderUps = new OrderEntity();
        $orderUps->setShippingProviderKey($shippingProviderKeyUps);

        $shippingProviderKeyOmniva = 'omniva';
        $orderOmniva = new OrderEntity();
        $orderOmniva->setShippingProviderKey($shippingProviderKeyOmniva);

        return [
            'ups' => [
                $orderUps,
                $shippingProviderKeyUps,
                $this->createMock(UPS::class)
            ],
            'omniva' => [
                $orderOmniva,
                $shippingProviderKeyOmniva,
                $this->createMock(Omniva::class)
            ],
        ];
    }
}
