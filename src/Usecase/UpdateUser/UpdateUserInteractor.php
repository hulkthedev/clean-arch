<?php

namespace App\Usecase\UpdateUser;

use App\Usecase\BaseInteractor;
use App\Usecase\BaseResponse;
use App\Usecase\ResultCodes;
use Symfony\Component\HttpClient\Exception\InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\UnsupportedMediaTypeHttpException;
use Throwable;

class UpdateUserInteractor extends BaseInteractor
{
    /**
     * @param Request $request
     * @return BaseResponse
     */
    public function execute(Request $request): BaseResponse
    {
        $code = ResultCodes::SUCCESS_NO_CONTENT;

        try {
            $this->validateRequest($request);

            $user = $this->createUserFromRequest($request);
            $this->getRepository()->updateUserById($user);
        } catch (UnsupportedMediaTypeHttpException $exception) {
            $code = ResultCodes::INVALID_MEDIA_TYPE;
        } catch (InvalidArgumentException $exception) {
            $code = ResultCodes::INVALID_SYNTAX;
        } catch (Throwable $throwable) {
            $code = ResultCodes::UNKNOWN_ERROR;
        }

        return new BaseResponse($code);
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
