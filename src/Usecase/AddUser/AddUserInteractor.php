<?php

namespace App\Usecase\AddUser;

use App\Entity\User;
use App\Repository\Exception\DatabaseException;
use App\Usecase\BaseInteractor;
use App\Usecase\BaseResponse;
use App\Usecase\ResultCodes;
use Symfony\Component\HttpClient\Exception\InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\UnsupportedMediaTypeHttpException;
use Throwable;

class AddUserInteractor extends BaseInteractor
{
    /**
     * @param Request $request
     * @return BaseResponse
     */
    public function execute(Request $request): BaseResponse
    {
        $code = ResultCodes::SUCCESS_CREATED;
        $header = [];

        try {
            $this->validateRequest($request);

            $user = $this->createUserFromRequest($request);
            $userId = $this->getRepository()->addUser($user);

            $uri = $request->getUri();
            $header = ['Location' => "{$uri}{$userId}"];
        } catch (UnsupportedMediaTypeHttpException $exception) {
            $code = ResultCodes::INVALID_MEDIA_TYPE;
        } catch (InvalidArgumentException $exception) {
            $code = ResultCodes::INVALID_SYNTAX;
        } catch (DatabaseException $exception) {
            $code = ResultCodes::USER_CAN_NOT_BE_SAVED;
        } catch (Throwable $throwable) {
            $code = ResultCodes::UNKNOWN_ERROR;
        }

        $response = new BaseResponse($code);
        $response->setHeaders($header);

        return $response;
    }

    /**
     * @param Request $request
     * @throws InvalidArgumentException
     */
    private function validateRequest(Request $request)
    {
        $this->validateContentType($request->getContentType());
        $payload = $this->getUserFromRequest($request->getContent());

        if (!isset($payload['firstname'], $payload['lastname'], $payload['age'], $payload['gender'], $payload['street']) ||
            !isset($payload['houseNumber'], $payload['postcode'], $payload['city'],$payload['country'])) {
            throw new InvalidArgumentException('Missing user data!');
        }
    }
}
