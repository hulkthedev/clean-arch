<?php

namespace App\Usecase;

use App\Repository\RepositoryInterface as Repository;
use App\Usecase\Exception\BadRequestException;
use App\Usecase\Exception\MissingParameterException;
use Symfony\Component\HttpFoundation\Request;

abstract class BaseInteractor
{
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
