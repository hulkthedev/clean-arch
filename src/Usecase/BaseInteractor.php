<?php

namespace App\Usecase;

use App\Repository\RepositoryInterface as Repository;
use Symfony\Component\HttpKernel\Exception\UnsupportedMediaTypeHttpException;

class BaseInteractor
{
    protected const SUPPORTED_MEDIA_TYPE = 'json';

    private Repository $repository;

    /**
     * @param Repository $repository
     */
    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return Repository
     */
    protected function getRepository(): Repository
    {
        return $this->repository;
    }

    /**
     * @param string $contentType
     * @throws UnsupportedMediaTypeHttpException
     */
    protected function validateContentType(string $contentType): void
    {
        if (self::SUPPORTED_MEDIA_TYPE !== strtolower($contentType)) {
            throw new UnsupportedMediaTypeHttpException('Unsupported media type was transmitted!');
        }
    }
}
