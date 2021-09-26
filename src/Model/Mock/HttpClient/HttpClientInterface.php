<?php

declare(strict_types=1);

namespace App\Model\Mock\HttpClient;

use Symfony\Contracts\HttpClient\ResponseInterface;

/**
 * norejau vietoj sito naudoti Symfony\Contracts\HttpClient\HttpClientInterface,
 * bet atsoko noras kai pamaciau kiek mock'u kurt reikes :D
 */
interface HttpClientInterface
{
    public const METHOD_POST = 'POST';

    public const KEY_URL = 'url';
    public const KEY_RESPONSE = 'response';

    /**
     * @param string $method
     * @param string $url
     * @param array $options
     * @return ResponseInterface
     */
    public function request(
        string $method,
        string $url,
        array $options = []
    ): ResponseInterface;
}