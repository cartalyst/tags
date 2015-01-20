# Contribution Guide

This project adheres to the following standards and practices.

## Versioning

This package is versioned under the [Semantic Versioning](http://semver.org/) guidelines as much as possible.

Releases will be numbered with the following format:

`<major>.<minor>.<patch>`

And constructed with the following guidelines:

* Breaking backward compatibility bumps the major and resets the minor and patch.
* New additions without breaking backward compatibility bumps the minor and resets the patch.
* Bug fixes and misc changes bumps the patch.

## Coding Standards

This package is compliant with the [PSR-1](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-1-basic-coding-standard.md), [PSR-2](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md) and [PSR-4](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md). If you notice any compliance oversights, please send a patch via pull request.

## Pull Requests

The pull request process differs for new features and bugs.

Pull requests for bugs may be sent without creating any proposal issue. If you believe that you know of a solution for a bug that has been filed, please leave a comment detailing your proposed fix or create a pull request with the fix mentioning that issue id.

### Proposal Requests

If you have a proposal, you may create an issue with `[Proposal]` in the title.

The proposal should also describe the new feature, as well as implementation ideas. The proposal will then be reviewed and either approved or denied. Once a proposal is approved, a pull request may be created implementing the new feature.

### Feature Requests

If you have an idea for a new feature you would like to see added to the package, you may create an issue with `[Request]` in the title. The feature request will then be reviewed by a core contributor.

### Which Branch?

**ALL** bug fixes should be made to the branch which they belong. Bug fixes should never be sent to the `master` branch unless they fix features that exist only in the upcoming release.

> **Note:** Pull requests which do not follow these guidelines will be closed without any further notice.
