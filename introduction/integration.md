## Integration

Cartalyst packages are framework agnostic and as such can be integrated easily natively or with your favorite framework.

### Laravel

Integrating the package into Laravel 4.2 and 5.0 is incredibly easy.

> **Note:** Looking for Laravel 5.1 support? Check the [2.0 version](https://cartalyst.com/manual/tags/2.0).

#### Migrations

Run one of the following commands to run the Tags migrations:

**Laravel 4.2:**

`php artisan migrate --package=cartalyst/tags`

**Laravel 5.0:**

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
