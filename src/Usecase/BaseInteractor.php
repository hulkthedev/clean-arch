<?php

namespace App\Usecase;

use App\Repository\RepositoryInterface as Repository;

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
}
