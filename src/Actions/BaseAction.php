<?php

namespace Ofload\Butn\Actions;

use GuzzleHttp\Exception\ClientException;
use Ofload\Butn\Exceptions\ButnClientException;

abstract class BaseAction
{
    abstract public function execute(): mixed;

    /**
     * @throws ButnClientException
     */
    protected function throwButnClientException(ClientException $exception): void
    {
        $error = json_decode($exception->getResponse()->getBody()->getContents());
        $errorMessage = $error->error_description ?? $error->description ?? $exception->getMessage();
        throw new ButnClientException($errorMessage, $exception->getCode());
    }
}
