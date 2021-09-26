<?php

namespace App\Model\ShippingProvider;

use App\Entity\Order as OrderEntity;

interface ShippingProviderInterface
{
    /**
     * @param OrderEntity $order
     */
    public function notify(OrderEntity $order): void;
}