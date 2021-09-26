<?php

declare(strict_types=1);

namespace App\Entity;

class Order
{
    /*
     * sito turbut nereiketu, nes toks dalykas turbut butu nustatytas duombazeje
     */
    private const DEFAULT_SHIPPING_PROVIDER = 'ups';

    /** @var string */
    private $id;

    /** @var string */
    private $shippingProviderKey = self::DEFAULT_SHIPPING_PROVIDER;

    /** @var string */
    private $street;

    /** @var string */
    private $postCode;

    /** @var string */
    private $city;

    /** @var string */
    private $country;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * funkcija turbut nebutu reikalinga aplamai,
     * nes id butu generuojamas automatiskai ORM'o
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getShippingProviderKey(): string
    {
        return $this->shippingProviderKey;
    }

    /**
     * @param string $shippingProviderKey
     */
    public function setShippingProviderKey(string $shippingProviderKey): void
    {
        $this->shippingProviderKey = $shippingProviderKey;
    }

    /**
     * @return string
     */
    public function getStreet(): string
    {
        return $this->street;
    }

    /**
     * @param string $street
     */
    public function setStreet(string $street): void
    {
        $this->street = $street;
    }

    /**
     * @return string
     */
    public function getPostCode(): string
    {
        return $this->postCode;
    }

    /**
     * @param string $postCode
     */
    public function setPostCode(string $postCode): void
    {
        $this->postCode = $postCode;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry(string $country): void
    {
        $this->country = $country;
    }
}
