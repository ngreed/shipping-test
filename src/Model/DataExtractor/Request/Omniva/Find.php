<?php

declare(strict_types=1);

namespace App\Model\DataExtractor\Request\Omniva;

use App\Entity\Order as OrderEntity;
use App\Model\DataExtractor\Request\Request;

class Find implements Request
{
    private const KEY_COUNTY = 'country';
    private const KEY_POST_CODE = 'post_code';

    /**
     * @inheritDoc
     */
    public function extract(OrderEntity $order, array $additionalFields = []): array
    {
        return [
            self::KEY_COUNTY => $order->getCountry(),
            self::KEY_POST_CODE => $order->getPostCode()
        ];
    }
}