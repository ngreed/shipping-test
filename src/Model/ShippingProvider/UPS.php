<?php

declare(strict_types=1);

namespace App\Model\ShippingProvider;

use App\Entity\Order as OrderEntity;
use App\Model\DataExtractor\Request\Request as RequestDataExtractor;
use App\Model\Mock\HttpClient\HttpClientInterface;

class UPS implements ShippingProviderInterface
{
    public const URL_REGISTER = 'upsfake.com/register';

    /** @var HttpClientInterface */
    private $httpClient;

    /** @var RequestDataExtractor */
    private $dataExtractor;

    /**
     * @param HttpClientInterface $httpClient
     * @param RequestDataExtractor $dataExtractor
     */
    public function __construct(
        HttpClientInterface $httpClient,
        RequestDataExtractor $dataExtractor
    ) {
        $this->httpClient = $httpClient;
        $this->dataExtractor = $dataExtractor;
    }

    /**
     * @inheritDoc
     */
    public function notify(OrderEntity $order): void
    {
        /*
         * reiketu validuoti grazinamus duomenis
         */
        $this->httpClient->request(
            HttpClientInterface::METHOD_POST,
            self::URL_REGISTER,
            $this->dataExtractor->extract($order)
        );
    }
}