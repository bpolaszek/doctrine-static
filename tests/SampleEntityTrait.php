<?php

namespace BenTools\DoctrineStatic\Tests;

trait SampleEntityTrait
{
    /**
     * Fakes a Doctrine entity object.
     * @param $id
     * @param $name
     */
    private function createSampleEntity($id, $name)
    {
        return new class($id, $name)
        {
            private $id, $name;

            public function __construct($id, $name)
            {
                $this->id = $id;
                $this->name = $name;
            }

            public function getId()
            {
                return $this->id;
            }

            public function getName()
            {
                return $this->name;
            }

        };
    }
}