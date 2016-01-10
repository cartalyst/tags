# Change Log

This project follows [Semantic Versioning](CONTRIBUTING.md).

## Proposals

We do not give estimated times for completion on `Accepted` Proposals.

- [Accepted](https://github.com/cartalyst/tags/labels/Accepted)
- [Rejected](https://github.com/cartalyst/tags/labels/Rejected)

---

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
