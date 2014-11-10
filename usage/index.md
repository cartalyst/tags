## Usage

..

### Add Tags

..

```php
// Get the entity object
$product = Product::find(1);

// Through a string
$product->tag('foo, bar, baz');

// Through an array
$product->tag([ 'foo', 'bar', 'baz' ]);
```

### Remove Tags

..

```php
// Get the entity object
$product = Product::find(1);

// Through a string
$product->untag('bar, baz');

// Through an array
$product->untag([ 'bar', 'baz' ]);
```

### Reading Tags

..

###### Get all the tags from an Entity

This will return all the tags that are attached to the given Entity.

```
$product = Product::find(1);

$tags = $product->tags;
```

###### Get all the tags from an Entity Namespace

This will return all the tags that belongs to the given Entity Namespace.

```
$tags = Product::allTags();
```

### Slug Generator

The Tags package needs a way to create a sluggified tagged name, to achieve this, by default we use the `Illuminate\Support\Str::slug` method but if required you can easily swap the Slug Generator method to one that fits your own needs.

#### Get the Slug Generator

This will return the current Slug Generator.

```php
$generator = Product::getSlugGenerator();
```

#### Set the Slug Generator

This allows you to change the Slug Generator.

```php
// Through a class@method string
Product::setSlugGenerator('MyGenerator::slug');

// Through a Closure
Product::setSlugGenerator(function($name)
{
	return str_replace(' ', '_', strtolower($name));
});
```
