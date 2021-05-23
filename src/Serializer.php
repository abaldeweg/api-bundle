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
            $value = $propertyAccessor->getValue($entity, $field);
            if ($value instanceof \DateTime) {
                $value = $value->getTimestamp();
            }
            $object[$field] = $value;
        }

        return $object;
    }
}
