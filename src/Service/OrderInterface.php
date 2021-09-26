<?php

namespace App\Service;

use App\Entity\Order as OrderEntity;

interface OrderInterface
{
    /**
     * @param OrderEntity $order
     */
    public function registerShipping(OrderEntity $order): void;
}
