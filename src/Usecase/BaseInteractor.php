<?php

namespace App\Usecase;

use App\Entity\User;
use App\Repository\RepositoryInterface as Repository;
use Symfony\Component\HttpFoundation\Request;
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
     * @param string $payload
     * @return array
     */
    protected function getUserFromRequest(string $payload): array
    {
        return json_decode($payload, true);
    }

    /**
     * @param Request $request
     * @return User
     */
    protected function createUserFromRequest(Request $request): User
    {
        $payload = $this->getUserFromRequest($request->getContent());

        $user = new User();
        $user->id = $payload['id'] ?? 0;
        $user->firstname = $payload['firstname'] ?? '';
        $user->lastname = $payload['lastname'] ?? '';
        $user->age = $payload['age'] ?? 0;
        $user->gender = $payload['gender'] ?? '';
        $user->street = $payload['street'] ?? '';
        $user->houseNumber = $payload['houseNumber'] ?? '';
        $user->postcode = $payload['postcode'] ?? '';
        $user->city = $payload['city'] ?? '';
        $user->country = $payload['country'] ?? '';

        return $user;
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
