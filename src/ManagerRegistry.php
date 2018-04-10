<?php

namespace BenTools\DoctrineStatic;

use Doctrine\Common\Util\ClassUtils;

final class ManagerRegistry implements \Doctrine\Common\Persistence\ManagerRegistry
{

    /**
     * @var \Doctrine\Common\Persistence\ObjectManager[]
     */
    private $objectManagers;
    /**
     * @var string
     */
    private $defaultManagerName;

    /**
     * ManagerRegistry constructor.
     * @param array $objectManagers
     */
    public function __construct(array $objectManagers = [], string $defaultManagerName = 'default')
    {
        (function (\Doctrine\Common\Persistence\ObjectManager $objectManager) {
        })(...array_values($objectManagers));
        $this->objectManagers = $objectManagers;
        $this->defaultManagerName = $defaultManagerName;
    }

    /**
     * @inheritDoc
     */
    public function getDefaultConnectionName()
    {
        throw new \LogicException(sprintf('%s is not implemented.', __METHOD__));
    }

    /**
     * @inheritDoc
     */
    public function getConnection($name = null)
    {
        throw new \LogicException(sprintf('%s is not implemented.', __METHOD__));
    }

    /**
     * @inheritDoc
     */
    public function getConnections()
    {
        throw new \LogicException(sprintf('%s is not implemented.', __METHOD__));
    }

    /**
     * @inheritDoc
     */
    public function getConnectionNames()
    {
        throw new \LogicException(sprintf('%s is not implemented.', __METHOD__));
    }

    /**
     * @inheritDoc
     */
    public function getDefaultManagerName()
    {
        return $this->defaultManagerName;
    }

    /**
     * @inheritDoc
     */
    public function getManager($name = null)
    {
        if (null === $name) {
            $name = $this->getDefaultManagerName();
        }
        return $this->objectManagers[$name] ?? null;
    }

    /**
     * @inheritDoc
     */
    public function getManagers()
    {
        return $this->objectManagers;
    }

    /**
     * @inheritDoc
     */
    public function resetManager($name = null)
    {
        throw new \LogicException(sprintf('%s is not implemented.', __METHOD__));
    }

    /**
     * @inheritDoc
     */
    public function getAliasNamespace($alias)
    {
        throw new \LogicException(sprintf('%s is not implemented.', __METHOD__));
    }

    /**
     * @inheritDoc
     */
    public function getManagerNames()
    {
        return array_keys($this->objectManagers);
    }

    /**
     * @inheritDoc
     */
    public function getRepository($persistentObject, $persistentManagerName = null)
    {
        foreach ($this->objectManagers as $manager) {
            if (null !== $manager->getRepository(ClassUtils::getClass($persistentObject))) {
                return $manager;
            }
        }
        return null;
    }

    /**
     * @inheritDoc
     */
    public function getManagerForClass($class)
    {
        foreach ($this->objectManagers as $manager) {
            if (null !== $manager->getRepository($class)) {
                return $manager;
            }
        }
        return null;
    }
}
