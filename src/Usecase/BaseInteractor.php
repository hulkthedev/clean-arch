<?php

namespace App\Usecase;

use App\Repository\RepositoryInterface as Repository;
use App\Usecase\Exceptions\BadRequestException;
use App\Usecase\Exceptions\MissingParameterException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\UnsupportedMediaTypeHttpException;

abstract class BaseInteractor
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
     * @param Request $request
     * @throws UnsupportedMediaTypeHttpException
     * @throws BadRequestException
     * @throws MissingParameterException
     */
    abstract protected function validateRequest(Request $request): void;

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

    /**
     * @param Request $request
     * @throws UnsupportedMediaTypeHttpException
     * @throws BadRequestException
     * @throws MissingParameterException
     */
    protected function validateContractNumber(Request $request): void
    {
        if (null === $request->get('contractNumber')) {
            throw new BadRequestException('No contractId transmitted!', );
        }

        if ((int)$request->get('contractNumber') === 0) {
            throw new MissingParameterException();
        }
    }

    /**
     * @param Request $request
     * @throws BadRequestException
     * @throws MissingParameterException
     */
    protected function validateDate(Request $request): void
    {
        if (null === $request->get('date')) {
            throw new BadRequestException();
        }

        if ('' === $request->get('date')) {
            throw new MissingParameterException();
        }
    }
}
