<?php

declare(strict_types=1);

namespace App\Model\DataExtractor\Request\Omniva;

use App\Entity\Order as OrderEntity;
use App\Model\DataExtractor\Request\Request;

class Register implements Request
{
    public const KEY_PICKUP_POINT_ID = 'pickup_point_id';
    private const KEY_ORDER_ID = 'order_id';

    /**
     * @inheritDoc
     */
    public function extract(OrderEntity $order, array $additionalFields = []): array
    {
        return [
            self::KEY_PICKUP_POINT_ID => $additionalFields[self::KEY_PICKUP_POINT_ID],
            self::KEY_ORDER_ID => $order->getId()
        ];
    }
}