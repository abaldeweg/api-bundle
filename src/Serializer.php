<?php

namespace Baldeweg\Bundle\ApiBundle;

use Symfony\Component\PropertyAccess\PropertyAccess;

class Serializer implements SerializerInterface
{
    public function serialize($entity, array $fields): array
    {
        $propertyAccessor = PropertyAccess::createPropertyAccessor();

        $object = [];
        foreach ($fields as $field) {
            $item = explode(':', $field);

            $property = $this->transformFieldName($item[0]);
            $value = $this->transformValue(
                isset($item[1]) ? $item[1] : null,
                $propertyAccessor->getValue($entity, $item[0])
            );

            $object[$property] = $value;
        }

        return $object;
    }

    private function transformFieldName(string $field): string
    {
        return str_replace('.', '_', $field);
    }

    private function transformValue(?string $type = null, $value = null): mixed
    {
        if ('timestamp' === $type && $value instanceof \DateTime) {
            $value = $value->getTimestamp();
        }
        if ('count' === $type) {
            $value = count($value);
        }

        return $value;
    }
}
