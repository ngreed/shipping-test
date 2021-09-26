<?php

declare(strict_types=1);

namespace App\Model\Mock\HttpClient\Response\UPS;

use Symfony\Contracts\HttpClient\ResponseInterface;

/**
 * Kaip matote su sitais mock'ais nepersistengiau :D
 */
class Register implements ResponseInterface
{
    /**
     * @inheritDoc
     */
    public function getStatusCode(): int
    {
        return 200;
    }

    /**
     * @inheritDoc
     */
    public function getHeaders(bool $throw = true): array
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function getContent(bool $throw = true): string
    {
        return '';
    }

    /**
     * @inheritDoc
     */
    public function toArray(bool $throw = true): array
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function cancel(): void
    {

    }

    /**
     * @inheritDoc
     */
    public function getInfo(string $type = null)
    {

    }
}