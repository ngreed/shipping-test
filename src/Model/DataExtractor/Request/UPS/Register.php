<?php

declare(strict_types=1);

namespace App\Model\DataExtractor\Request\UPS;

use App\Entity\Order as OrderEntity;
use App\Model\DataExtractor\Request\Request;

class Register implements Request
{
    private const KEY_ORDER_ID = 'order_id';
    private const KEY_COUNTRY = 'country';
    private const KEY_STREET = 'street';
    private const KEY_CITY = 'city';
    private const KEY_POST_CODE = 'post_code';

    /**
     * @inheritDoc
     */
    public function extract(OrderEntity $order, array $additionalFields = []): array
    {
        return [
            self::KEY_ORDER_ID => $order->getId(),
            self::KEY_COUNTRY => $order->getCountry(),
            self::KEY_STREET => $order->getStreet(),
            self::KEY_CITY => $order->getCity(),
            self::KEY_POST_CODE => $order->getPostCode()
        ];
    }
}