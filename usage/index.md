## Usage

In this section we'll show how you can manage your entities tags.

### Adding Tags

Adds a single or multiple tags to the entity through an array or through a string separated by the entity [delimiter](#delimiter).

##### Parameters

Key   | Required | Type          | Description
----- | -------- | ------------- | ---------------------------------------------
$tags | true     | string, array | The tags to be added to the entity.

##### Usage

```php
// Get the entity object
$product = Product::find(1);

// Through a string
$product->tag('foo, bar, baz');

// Through an array
$product->tag([ 'foo', 'bar', 'baz' ]);
```

### Removing Tags

Removes a single or multiple tags to the entity through an array or through a string separated by the entity [delimiter](#delimiter).

##### Parameters

Key   | Required | Type          | Description
----- | -------- | ------------- | ---------------------------------------------
$tags | true     | string, array | The tags to be added to the entity.

##### Usage

```php
// Get the entity object
$product = Product::find(1);

// Through a string
$product->untag('bar, baz');

// Through an array
$product->untag([ 'bar', 'baz' ]);

// Remove all the tags
$product->untag();
```

### Setting Tags

This method is very similar to the `tag()` method, but it combines the `untag()` aswell, so it automatically identifies the tags to add and remove.

It's a very useful method when running updates on entities and you don't want to deal with the checks to verify what tags needs to be added or removed.

##### Parameters

Key   | Required | Type          | Description
----- | -------- | ------------- | ---------------------------------------------
$tags | true     | string, array | The tags to be added to the entity.
$type | false    | string        | The column name to use when doing the verification checks.

##### Usage

```php
// Get the entity object
$product = Product::find(1);

// Through a string
$product->setTags('foo, bar, baz');

// Through an array
$product->setTags([ 'foo', 'bar', 'baz' ]);

// Using the `slug` column
$product->setTags([ 'foo', 'bar', 'baz' ], 'slug');
```

### Reading Tags

We have some methods to help you get all the tags attached to an Entity and do the inverse and retrieve all the Entities with the given tags.

#### Get all the Entities with the given tags

This will return all the Entities that has all of the given tags attached.

```php
$products = Product::whereTag('foo, bar')->get();
```

#### Get all the Entities with at least one of the tags

This will return all the Entities that has at least one of the given tags attached.

```php
$products = Product::withTag('foo, bar')->get();
```

#### Get all the tags from an Entity

This will return all the tags that are attached to the given Entity.

```
$product = Product::find(1);

$tags = $product->tags;
```

#### Get all the tags from an Entity Namespace

This will return all the tags that belongs to the given Entity Namespace.

```
$tags = Product::allTags()->get();
```

### Delimiter

When adding or removing tags, you can pass multiple tags as an array or a string, if a string is passed, a delimiter needs to be used to separate each tag.

Here's how you can check the current delimiter behavior and how to change it if you desire.

#### Get Delimiter

To retrieve the current tags delimiter you can use use `getTagsDelimiter()` method.

```php
$delimiter = Product::getTagsDelimiter();
```

#### Set Delimiter

To set a different delimiter, use the `setTagsDelimiter($delimiter)` method.

##### Parameters

Key        | Required | Type    | Description
---------- | -------- | ------- | ----------------------------------------------
$delimiter | true     | string  | The delimiter to be used.

##### Usage

```php
Product::setTagsDelimiter(';');
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

##### Parameters

Key            | Required | Type  | Description
-------------- | -------- | ----- | --------------------------------------------
$slugGenerator | true     | mixed | The slug generation method name or Closure.

##### Usage

```php
// Through a function string
Product::setSlugGenerator('slugify_string');

// Through a class@method string
Product::setSlugGenerator('MyGenerator::slug');

// Through a Closure
Product::setSlugGenerator(function($name) {
	return str_replace(' ', '_', strtolower($name));
});
```
