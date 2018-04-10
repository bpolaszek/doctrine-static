<?php

namespace BenTools\DoctrineStatic;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Selectable;

final class ObjectRepository implements \Doctrine\Common\Persistence\ObjectRepository, Selectable
{
    /**
     * @var Collection
     */
    private $storage;

    /**
     * @var string
     */
    private $className = '';

    /**
     * @var \ReflectionProperty
     */
    private $refl;

    /**
     * ObjectRepository constructor.
     * @param string          $className
     * @param string          $idProperty
     * @param Collection|null $storage
     * @throws \ReflectionException
     */
    public function __construct(string $className, string $idProperty = 'id', Collection $storage = null)
    {
        $this->className = $className;
        $this->storage = $storage ?? new ArrayCollection();
        $this->refl = new \ReflectionProperty($className, $idProperty);
        if (!$this->refl->isPublic()) {
            $this->refl->setAccessible(true);
        }
    }

    /**
     * @inheritDoc
     */
    public function find($id)
    {
        return $this->storage[$id] ?? null;
    }

    /**
     * @inheritDoc
     */
    public function findAll()
    {
        return $this->storage->getValues();
    }

    /**
     * @inheritDoc
     */
    public function findBy(array $params, array $orderBy = null, $limit = null, $offset = null)
    {
        $criteria = Criteria::create();
        foreach ($params as $key => $value) {
            $criteria = $criteria->andWhere(Criteria::expr()->eq($key, $value));
        }
        if (null !== $orderBy) {
            $criteria = $criteria->orderBy($orderBy);
        }

        if (null !== $limit) {
            $criteria = $criteria->setMaxResults($limit);
        }

        if (null !== $offset) {
            $criteria = $criteria->setFirstResult($offset);
        }

        return $this->matching($criteria)->getValues();
    }

    /**
     * @inheritDoc
     */
    public function matching(Criteria $criteria)
    {
        return $this->storage->matching($criteria);
    }

    /**
     * @inheritDoc
     */
    public function findOneBy(array $criteria)
    {
        foreach ($this->findBy($criteria, null, 1) as $item) {
            return $item;
        }
        return null;
    }

    /**
     * @inheritDoc
     */
    public function getClassName()
    {
        return $this->className;
    }

    public function store($object)
    {
        $id = $this->refl->getValue($object);
        if (null === $id) {
            throw new \RuntimeException('Object Id not provided');
        }
        $this->storage->set($id, $object);
    }

    public function remove($object)
    {
        $this->storage->removeElement($object);
    }
}
