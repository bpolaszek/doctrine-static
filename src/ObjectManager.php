<?php

namespace BenTools\DoctrineStatic;

final class ObjectManager implements \Doctrine\Common\Persistence\ObjectManager
{
    private $repositories;
    private $tmpStorage = [];

    /**
     * ObjectManager constructor.
     * @param \Doctrine\Common\Persistence\ObjectRepository[] $repositories
     */
    public function __construct(array $repositories)
    {
        (function (\Doctrine\Common\Persistence\ObjectRepository ...$objectRepositories) {
        })(...array_values($repositories));
    foreach ($repositories as $repository) {
        $this->repositories[$repository->getClassName()] = $repository;
    }
    }

    /**
     * @inheritDoc
     */
    public function find($className, $id)
    {
        return $this->getRepository($className)->find($id);
    }

    /**
     * @inheritDoc
     */
    public function persist($object)
    {
        $this->tmpStorage[] = $object;
    }

    /**
     * @inheritDoc
     */
    public function remove($object)
    {
        $this->getRepository(get_class($object))->remove($object);
    }

    /**
     * @inheritDoc
     */
    public function merge($object)
    {
        throw new \LogicException(sprintf('%s is not implemented.', __METHOD__));
    }

    /**
     * @inheritDoc
     */
    public function clear($objectName = null)
    {
        throw new \LogicException(sprintf('%s is not implemented.', __METHOD__));
    }

    /**
     * @inheritDoc
     */
    public function detach($object)
    {
        throw new \LogicException(sprintf('%s is not implemented.', __METHOD__));
    }

    /**
     * @inheritDoc
     */
    public function refresh($object)
    {
        throw new \LogicException(sprintf('%s is not implemented.', __METHOD__));
    }

    /**
     * @inheritDoc
     */
    public function flush()
    {
        foreach ($this->tmpStorage as $o => $object) {
            $this->getRepository(get_class($object))->store($object);
            unset($this->tmpStorage[$o]);
        }
    }

    /**
     * @inheritDoc
     */
    public function getRepository($className)
    {
        return $this->repositories[$className] ?? null;
    }

    /**
     * @inheritDoc
     */
    public function getClassMetadata($className)
    {
        throw new \LogicException(sprintf('%s is not implemented.', __METHOD__));
    }

    /**
     * @inheritDoc
     */
    public function getMetadataFactory()
    {
        throw new \LogicException(sprintf('%s is not implemented.', __METHOD__));
    }

    /**
     * @inheritDoc
     */
    public function initializeObject($obj)
    {
        throw new \LogicException(sprintf('%s is not implemented.', __METHOD__));
    }

    /**
     * @inheritDoc
     */
    public function contains($object)
    {
        $className = get_class($object);
        return null !== $this->find($className, $object->getId()) || in_array($object, $this->tmpStorage);
    }
}
