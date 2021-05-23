# baldeweg/api-bundle

Offers tools for API's.

## Getting Started

```shell
composer req baldeweg/api-bundle
```

Activate the bundle in your `config/bundles.php`, if not done automatically.

```php
Baldeweg\Bundle\ApiBundle\BaldewegApiBundle::class => ['all' => true],
```

## Usage

```php
use Baldeweg\Bundle\ApiBundle\Serializer;

$fields = ['test', 'date', 'child.title'];

$serializer = new Serializer();
$serializer->serialize($entity, $fields);
```
