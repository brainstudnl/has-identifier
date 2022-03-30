# Has Identifier
Automatically fill the `identifier` of your model by adding the `HasIdentifier` trait.

## Installation
Require the package

```bash
composer require brainstud/has-identifier
```

## Usage
Add the `HasIdentifier` trait to your model. 

```php
/**
 * @property string $identifier
 */
class Item extends Model
{
    use HasIdentifier;
    
    protected $fillable = [
        'identifier'
    ];
}
```

The identifier will be filled on creation.
```php
$model = Item::create();
echo $model->identifier;
```

### Use a different identifier attribute
The trait will use the `identifier` property of your model to generate an identifier to.
You can overwrite the property the trait uses by setting the `identifierAttribute` on your model.

```php
/**
 * @property string $identifier
 */
class Item extends Model
{
    use HasIdentifier;
    
    protected string $identifierAttribute = 'uuid';
    
    protected $fillable = [
        'uuid'
    ];
}
```

### Find by identifier
There are different ways to get the model by identifier.

```php
// Find method
$model = Item::findByIdentifier($uuid);
$model = Item::findOrFailByIdentifier($uuid);

// Scope
$model = Item::identifiedBy($uuid)->first();
```

## Test
You can run the tests with

```bash
composer test
```

## License
has-identifier is open-sourced software licensed under the [MIT License](LICENSE)