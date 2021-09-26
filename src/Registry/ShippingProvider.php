<?php

declare(strict_types=1);

namespace App\Registry;

use App\Model\ShippingProvider\ShippingProviderInterface as ShippingProviderModel;

use Exception;

class ShippingProvider implements ShippingProviderInterface
{
    /** @var array */
    private $shippingProviders;

    /**
     * @param array $shippingProviders
     */
    public function __construct(iterable $shippingProviders)
    {
        $this->shippingProviders = $shippingProviders;
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function getShippingProvider(string $key): ShippingProviderModel
    {
        if (!isset($this->shippingProviders[$key])
            || !($this->shippingProviders[$key] instanceof ShippingProviderModel)
        ) {
            // Nepamaisytu vietoj generic \Exception throwinti savo sitam tikslui sukurta unikalu exceptiona
            throw new Exception(sprintf('Shipment provider with key "%s" does not exist', $key));
        }

        return $this->shippingProviders[$key];
    }
}
