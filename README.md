# Doctrine Static

This library is intended to be used for mocking ObjectManagers and Repositories behaviors in your unit tests. 

It is of course not intended to be used as a real persistence system.

## Main features

* Create different `ObjectManager` and store them in a `ManagerRegistry`
* Use `$objectManager->persist()`, `$objectManager->remove()` and `$objectManager->flush()` as usual (objects are stored in a temporary array before you call `flush()`)
* Use repository methods like `find()`, `findBy()`, `findOneBy()` and `findAll()`

## Unsupported features

* Everything UnitofWork-related
* Class metadata
* `merge`, `detach`, `refresh`, ...

## Example usage

```php
namespace App\Entity;

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
```

```php
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
```


## Installation

> composer require --dev benools/doctrine-static:1.0.x-dev

## Tests

> ./vendor/bin/phpunit

## License

MIT