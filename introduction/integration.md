## Integration

Cartalyst packages are framework agnostic and as such can be integrated easily natively or with your favorite framework.

### Laravel

Integrating the package into Laravel 5.1 is incredibly easy.

#### Migrations

Run the following command to run the Tags migrations:

`php artisan migrate --path=vendor/cartalyst/tags/src/migrations`

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
