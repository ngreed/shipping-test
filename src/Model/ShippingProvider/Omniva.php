<?php

declare(strict_types=1);

namespace App\Model\ShippingProvider;

use App\Entity\Order as OrderEntity;
use App\Model\DataExtractor\Request\Omniva\Register as RequestOmnivaRegisterDataExtractor;
use App\Model\DataExtractor\Request\Request as RequestDataExtractor;
use App\Model\Mock\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class Omniva implements ShippingProviderInterface
{
    /*
     * Priklausomai nuo to kiek standartizuoti provideriai,
     * sita info butu galima laikyti duombazeje.
     * Also, nenaudojant mock'u sita info galetu buti private matomumo
     */
    public const URL_FIND = 'omnivafake.com/pickup/find';
    public const URL_REGISTER = 'omnivafake.com/register';

    /** @var HttpClientInterface */
    private $httpClient;

    /** @var RequestDataExtractor */
    private $findDataExtractor;

    /** @var RequestDataExtractor */
    private $registerDataExtractor;

    /**
     * @param HttpClientInterface $httpClient
     * @param RequestDataExtractor $findDataExtractor
     * @param RequestDataExtractor $registerDataExtractor
     */
    public function __construct(
        HttpClientInterface $httpClient,
        RequestDataExtractor $findDataExtractor,
        RequestDataExtractor $registerDataExtractor
    ) {
        $this->httpClient = $httpClient;
        $this->findDataExtractor = $findDataExtractor;
        $this->registerDataExtractor = $registerDataExtractor;
    }

    /**
     * @inheritDoc
     */
    public function notify(OrderEntity $order): void
    {
        /*
         * reiketu validuoti grazinamus duomenis.
         * analogiskai ir su register()
         */
        $response = $this->find(
            $this->findDataExtractor->extract($order)
        );

        $this->register(
            $this->registerDataExtractor->extract(
                $order,
                [RequestOmnivaRegisterDataExtractor::KEY_PICKUP_POINT_ID => $response->getContent()] // realybej contentas turbut butu sudetingesnis ir pickup point id reiketu isextractinti is gauto response'o
            )
        );
    }

    /**
     * @param array $data
     * @return ResponseInterface
     */
    private function find(array $data): ResponseInterface
    {
        return $this->httpClient->request(
            HttpClientInterface::METHOD_POST,
            self::URL_FIND,
            $data
        );
    }

    /**
     * @param array $data
     * @return ResponseInterface
     */
    private function register(array $data): ResponseInterface
    {
        return $this->httpClient->request(
            HttpClientInterface::METHOD_POST,
            self::URL_REGISTER,
            $data
        );
    }
}