<?php

namespace App\Usecase\UpdateUser;

use App\Repository\Exception\DatabaseException;
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
        } catch(DatabaseException $exception) {
            $code = ResultCodes::USER_CAN_NOT_BE_UPDATED;
        } catch (Throwable $throwable) {
            $code = ResultCodes::UNKNOWN_ERROR;
        }

        return new BaseResponse($code);
    }

    /**
     * @param Request $request
     * @throws InvalidArgumentException
     * @throws UnsupportedMediaTypeHttpException
     */
    private function validateRequest(Request $request): void
    {
        $this->validateContentType($request->getContentType() ?? 'not set');

        if (null === $request->get('userId')) {
            throw new InvalidArgumentException('No userId transmitted!');
        }

        if (!is_integer((int)$request->get('userId'))) {
            throw new InvalidArgumentException('No valid userId transmitted!');
        }

        if (empty($this->getDataFromRequest($request->getContent()))) {
            throw new InvalidArgumentException('Missing user data!');
        }
    }
}
