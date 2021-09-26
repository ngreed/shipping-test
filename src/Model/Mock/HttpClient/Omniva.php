<?php

declare(strict_types=1);

namespace App\Model\Mock\HttpClient;

use Exception;
use Symfony\Contracts\HttpClient\ResponseInterface;

class Omniva implements HttpClientInterface
{
    /** @var array */
    private $responseMap;

    /**
     * @param array $responseMap
     */
    public function __construct(array $responseMap)
    {
        $this->responseMap = $responseMap;
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function request(
        string $method,
        string $url,
        array $options = []
    ): ResponseInterface {
        foreach ($this->responseMap as $responseMapEntry) {
            if ($url === $responseMapEntry[self::KEY_URL]) {
                return $responseMapEntry[self::KEY_RESPONSE];
            }
        }

        throw new Exception(
            sprintf(
                "Mock url '%s' response has not been added to configuration",
                $url
            )
        );
    }
}