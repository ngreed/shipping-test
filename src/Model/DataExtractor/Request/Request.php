<?php

namespace App\Model\DataExtractor\Request;

use App\Entity\Order as OrderEntity;

interface Request
{
    /**
     * @param OrderEntity $order
     * @param array $additionalFields
     * @return array
     */
    public function extract(OrderEntity $order, array $additionalFields = []): array;
}