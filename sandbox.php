<?php


namespace App\Entity {

    class Foo
    {

        private $id;
        private $name;

        /**
         * Foo constructor.
         * @param $id
         * @param $name
         */
        public function __construct($id, $name)
        {
            $this->id = $id;
            $this->name = $name;
        }

        /**
         * @return mixed
         */
        public function getId()
        {
            return $this->id;
        }

        /**
         * @return mixed
         */
        public function getName()
        {
            return $this->name;
        }

    }

}

namespace Prout {

    use App\Entity\Foo;
    use BenTools\DoctrineStatic\ManagerRegistry;
    use BenTools\DoctrineStatic\ObjectManager;
    use BenTools\DoctrineStatic\ObjectRepository;

    require_once __DIR__ . '/vendor/autoload.php';

    $foo = new Foo(2, 'foo');

    $doctrine = new ManagerRegistry([
        'default' => new ObjectManager([
                new ObjectRepository(Foo::class)
            ]
        ),
    ]);

    $em = $doctrine->getManager();
    $em->persist($foo);
    $em->flush();

    // Retrieve object by id
    $em->find(Foo::class, 2);

    // Retrieve objects with name matching "foo"
    $em->getRepository(Foo::class)->findBy(['name' => 'foo']);
}




