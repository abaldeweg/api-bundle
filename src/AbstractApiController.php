<?php

namespace Baldeweg\Bundle\ApiBundle;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

abstract class AbstractApiController extends AbstractController
{
    protected function response(array $data, int $code = 200, array $headers = []): JsonResponse
    {
        return new JsonResponse(
            json_encode($data),
            $code,
            $headers,
            true
        );
    }

    protected function serialize($data): array
    {
        if (!$this->fields) {
            throw new \Exception('Please set the fields attribute!');
        }

        $serializer = new Serializer();

        return $serializer->serialize($data, $this->fields);
    }

    protected function serializeCollection(array $data): array
    {
        $collection = [];
        foreach ($data as $item) {
            $collection[] = $this->serialize($item);
        }

        return $collection;
    }

    protected function invalid(): JsonResponse
    {
        return $this->response(['msg' => 'NOT_VALID'], 400);
    }

    protected function deleted(): JsonResponse
    {
        return $this->response(['msg' => 'DELETED']);
    }

    protected function submitForm(Request $request): array
    {
        return json_decode(
            $request->getContent(),
            true
        );
    }
}
