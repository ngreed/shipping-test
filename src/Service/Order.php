<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Order as OrderEntity;
use App\Registry\ShippingProviderInterface as ShippingProviderRegistryInterface;

class Order implements OrderInterface
{
    /** @var ShippingProviderRegistryInterface */
    private $shippingProviderRegistry;

    /**
     * @param ShippingProviderRegistryInterface $shippingProviderRegistry
     */
    public function __construct(ShippingProviderRegistryInterface $shippingProviderRegistry)
    {
        $this->shippingProviderRegistry = $shippingProviderRegistry;
    }

    /**
     * @inheritDoc
     */
    public function registerShipping(OrderEntity $order): void
    {
        $shippingProvider = $this->shippingProviderRegistry->getShippingProvider(
            $order->getShippingProviderKey()
        );

        $shippingProvider->notify($order);
    }
}
