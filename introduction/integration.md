## Integration

Cartalyst packages are framework agnostic and as such can be integrated easily natively or with your favorite framework.

### Laravel

Integrating the package into Laravel 10 is incredibly easy.

#### Migrations

Add the `Cartalyst\Tags\TagsServiceProvider` Service Provider into the `providers` array on your `config/app.php` file and run the following on your terminal to publish the migrations:

```sh
$ php artisan vendor:publish --provider="Cartalyst\Tags\TagsServiceProvider" --tag="migrations"
```

If you don't want to publish the migrations, just run the following on your terminal:

```sh
$ php artisan migrate --path=vendor/cartalyst/tags/resources/migrations
```

#### Setup Model(s)

Now all you need to do is to setup your Eloquent model(s).

Add the `Cartalyst\Tags\TaggableTrait` and implement the `Cartalyst\Tags\TaggableInterface` interface.

```php
<?php
use Cartalyst\Tags\TaggableTrait;
use Cartalyst\Tags\TaggableInterface;

class Product extends Eloquent implements TaggableInterface
{
    use TaggableTrait;
}
```
