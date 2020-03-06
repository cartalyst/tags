# Changelog

### v9.0.1 - 2020-03-06

`FIXED`

- Regression on the getter and setter for the custom slug generator.

### v9.0.0 - 2019-08-30

- BC Break: PHP 7.2 is the minimum required PHP version
- BC Break: Laravel 6.0 is the minimum supported Laravel version

### v8.0.0 - 2019-03-02

`ADDED`

- Laravel 5.8 support.

`REMOVED`

- Laravel 5.7 support.

### v7.0.0 - 2018-10-03

`ADDED`

- Laravel 5.7 support.

`REMOVED`

- Laravel 5.6 support.

### v6.0.1 - 2018-04-04

`FIXED`

- Issue where tags were not being reloaded after being updated.

### v6.0.0 - 2018-02-07

`ADDED`

- Laravel 5.6 support.

`REMOVED`

- Laravel 5.5 support.

### v5.0.0 - 2017-08-30

`ADDED`

- Laravel 5.5 support.

`REMOVED`

- Laravel 5.4 support.

### v4.0.1 - 2017-04-28

`FIXED`

- Issue with tags having names equal to SQL operators.
- Issue when calling untag multiple times to remove the same tag.

### v4.0.0 - 2017-01-30

`ADDED`

- Laravel 5.4 support.

`REMOVED`

- Laravel 5.3 support.

### v3.0.1 - 2017-04-28

`FIXED`

- Issue with tags having names equal to SQL operators.
- Issue when calling untag multiple times to remove the same tag.

### v3.0.0 - 2016-09-06

`ADDED`

- Laravel 5.3 support.

`REMOVED`

- Laravel 5.1 and 5.2 support.

### v2.1.3 - 2017-04-28

`FIXED`

- Issue with tags having names equal to SQL operators.
- Issue when calling untag multiple times to remove the same tag.

### v2.1.2 - 2016-09-05

`REVISED`

- Tightened dependencies to Laravel 5.1.x, 5.2.x.

### v2.1.1 - 2016-07-05

`FIXED`

- Issue with models having the `$table` property as public now allowing for proper extending.

### v2.1.0 - 2016-01-10

`ADDED`

- Scope `withoutTag`.

### v2.0.6 - 2017-04-28

`FIXED`

- Issue with tags having names equal to SQL operators.
- Issue when calling untag multiple times to remove the same tag.

### v2.0.5 - 2016-09-05

`REVISED`

- Tightened dependencies to Laravel 5.1.x, 5.2.x.

### v2.0.4 - 2016-07-05

`FIXED`

- Issue with models having the `$table` property as public now allowing for proper extending.

### v2.0.3 - 2016-01-10

`FIXED`

- Fix issue when trying to fetch the tagged entities from a tag.

`REVISED`

- Improve tests.

### v2.0.2 - 2015-07-24

`ADDED`

- Service Provider to allow migrations publishing.

`REVISED`

- Migrations path.

### v2.0.1 - 2015-07-09

`ADDED`

- `.gitattributes` and `.travis.yml` file.

`UPDATED`

- Build status badge to Travis CI.

### v2.0.0 - 2015-06-12

`ADDED`

- Laravel 5.1 support.

`REMOVED`

- Laravel 4.2 and 5.0 support.

### v1.0.5 - 2015-07-09

`ADDED`

- `.gitattributes` and `.travis.yml` file.

`UPDATED`

- Build status badge to Travis CI.

### v1.0.4 - 2015-06-12

`REVISED`

- PSR-2 compliance.
- Laravel dependencies.

`UPDATED`

- Minimum stability on `composer.json` to `stable`.

### v1.0.3 - 2015-05-13

`REVISED`

- Tightened dependencies to Laravel 4.2.x, 5.0.x.
- Allow tagging by slug.

### v1.0.2 - 2015-02-15

`REVISED`

- Loosened dependencies to work with Laravel 5.

### v1.0.1 - 2015-01-21

`ADDED`

- When deleting a Tag, it's now deleting the corresponding tagged entities tags.
- Added a `scopeSlug` to the IlluminateTag model to maintain consistency.

### v1.0.0 - 2015-01-20

- Initial stable release.
