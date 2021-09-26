<?php

namespace App\Builder;

use App\Entity\Order as OrderEntity;

interface OrderInterface
{
    /**
     * @param string $shippingProvider
     * @return OrderEntity
     */
    public function build(string $shippingProvider): OrderEntity;
}