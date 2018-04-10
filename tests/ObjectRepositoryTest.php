<?php

namespace BenTools\DoctrineStatic\Tests;

use BenTools\DoctrineStatic\ObjectRepository;
use PHPUnit\Framework\TestCase;

class ObjectRepositoryTest extends TestCase
{
    use SampleEntityTrait;

    public function testRepository()
    {
        $entity = $this->createSampleEntity('foo', 'bar');
        $className = get_class($entity);

        $repository = new ObjectRepository($className);
        $this->assertNull($repository->find($entity->getId()));

        $repository->store($entity);
        $this->assertNotNull($repository->find($entity->getId()));
        $this->assertSame($repository->find($entity->getId()), $entity);

        $repository->remove($entity);
        $this->assertNull($repository->find($entity->getId()));
    }
}
