<?php

namespace Baldeweg\Bundle\ApiBundle\Tests;

use Baldeweg\Bundle\ApiBundle\Serializer;
use PHPUnit\Framework\TestCase;

class SerializerTest extends TestCase
{
    public function testSerializer()
    {
        $child = $this
            ->getMockBuilder(\stdClass::class)
            ->addMethods(['getTitle'])
            ->getMock();
        $child->method('getTitle')->willReturn('title');

        $entity = $this
            ->getMockBuilder(\stdClass::class)
            ->addMethods(['getTest', 'getDate', 'getChild'])
            ->getMock();
        $entity->method('getTest')->willReturn('test');
        $entity->method('getDate')->willReturn(new \DateTime());
        $entity->method('getChild')->willReturn($child);

        $fields = ['test', 'date', 'child.title'];

        $serializer = new Serializer();

        $response = $serializer->serialize($entity, $fields);

        $this->assertIsArray($response);
        $this->assertEquals('test', $response['test']);
        $this->assertIsInt($response['date']);
        $this->assertEquals('title', $response['child.title']);
    }
}
