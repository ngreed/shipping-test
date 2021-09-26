<?php

declare(strict_types=1);

namespace App\Builder;

use App\Entity\Order as OrderEntity;

class Order implements OrderInterface
{
    /**
     * @inheritDoc
     *
     * Sita funkcija darant tikra varianta atrodytu kitaip,
     * kadangi turetu priimti gerokai daugiau info nei tik shipping provideri.
     * Esant nemazam kiekiui fieldu turbut galetume perduoti objekta arba bent asociatyvu masyva,
     * kuris pries tai butu sukurtas kitos klases
     * (sakykim OrderBuilderDataFormatter ar kazkuo pan.)
     */
    public function build(string $shippingProvider): OrderEntity
    {
        $order = new OrderEntity();
        $order->setId(uniqid());
        $order->setShippingProviderKey($shippingProvider);
        $order->setStreet('mock street');
        $order->setPostCode('mock post code');
        $order->setCity('mock city');
        $order->setCountry('mock country');

        return $order;
    }
}