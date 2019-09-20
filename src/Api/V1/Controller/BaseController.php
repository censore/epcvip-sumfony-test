<?php


namespace App\Api\V1\Controller;

use App\Controller\BaseController as MainController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class BaseController extends MainController
{

    /**
     * Parses the content of the request and then replace the request data on the $request object
     *
     * @param Request $request
     * @return Request
     */
    protected function parseJSONRequestBody(Request $request): Request
    {
        if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
            $data = json_decode($request->getContent(), true);
            $request->request->replace(is_array($data) ? $data : []);
        }

        return $request;
    }
    protected function errorsToArray(ConstraintViolationListInterface $errors): array
    {
        $errorsArray = [];

        if (count($errors) > 0) {
            foreach ($errors as $error) {
                $errorsArray[] = [$error->getPropertyPath() => $error->getMessage()];
            }
        }

        return $errorsArray;
    }

    protected function validationErrorsJsonResponse(array $errors): JsonResponse
    {
        return new JsonResponse(
            json_encode(['data' => $errors]),
            422,
            [],
            true
        );
    }
}