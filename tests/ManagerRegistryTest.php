<?php

namespace BenTools\DoctrineStatic\Tests;

use BenTools\DoctrineStatic\ManagerRegistry;
use BenTools\DoctrineStatic\ObjectManager;
use BenTools\DoctrineStatic\ObjectRepository;
use PHPUnit\Framework\TestCase;

class ManagerRegistryTest extends TestCase
{
    use SampleEntityTrait;

    public function testManagerRegistry()
    {
        $entity = $this->createSampleEntity('foo', 'bar');
        $className = get_class($entity);
        $repository = new ObjectRepository($className);
        $em = new ObjectManager([$repository]);
        $registry = new ManagerRegistry(['default' => $em]);
        $this->assertSame($registry->getManagerForClass($className), $em);
    }

}
