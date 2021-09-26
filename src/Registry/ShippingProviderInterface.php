<?php

namespace App\Registry;

use App\Model\ShippingProvider\ShippingProviderInterface as ShippingProviderModel;

interface ShippingProviderInterface
{
    /**
     * @param string $key
     * @return ShippingProviderModel
     */
    public function getShippingProvider(string $key): ShippingProviderModel;
}
