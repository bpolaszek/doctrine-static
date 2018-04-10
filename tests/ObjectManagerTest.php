<?php

namespace BenTools\DoctrineStatic\Tests;

use BenTools\DoctrineStatic\ObjectManager;
use BenTools\DoctrineStatic\ObjectRepository;
use PHPUnit\Framework\TestCase;

class ObjectManagerTest extends TestCase
{
    use SampleEntityTrait;

    public function testObjectManager()
    {
        $entity = $this->createSampleEntity('foo', 'bar');
        $className = get_class($entity);
        $repository = new ObjectRepository($className);
        $em = new ObjectManager([$repository]);

        $this->assertNull($em->find($className, $entity->getId()));
        $this->assertFalse($em->contains($entity));

        // Test persistence
        $em->persist($entity);
        $this->assertNull($em->find($className, $entity->getId()));
        $this->assertTrue($em->contains($entity));

        // Test Flush
        $em->flush();
        $this->assertNotNull($em->find($className, $entity->getId()));
        $this->assertTrue($em->contains($entity));
    }

}
