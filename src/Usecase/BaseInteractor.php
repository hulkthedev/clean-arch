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
     * @param Request $request
     * @param array $params
     * @throws BadRequestException
     * @throws MissingParameterException
     */
    protected function validateParameter(Request $request, array $params): void
    {
        foreach ($params as $param) {
            if (null === $request->get($param)) {
                throw new BadRequestException();
            }

            if ((int)$request->get($param) === 0) {
                throw new MissingParameterException();
            }
        }
    }
}
