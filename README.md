[![Latest Version on Packagist](http://img.shields.io/packagist/v/hofff/contao-formtools.svg?style=flat)](https://packagist.org/packages/hofff/contao-formtools)
[![Installations via composer per month](http://img.shields.io/packagist/dm/hofff/contao-formtools.svg?style=flat)](https://packagist.org/packages/hofff/contao-formtools)
[![Installations via composer total](http://img.shields.io/packagist/dt/hofff/contao-formtools.svg?style=flat)](https://packagist.org/packages/hofff/contao-formtools)

# Contao Extension: hofff.com - Formtools

This extension provides some extended features for the Contao form generator.

## Features

- in the content element or module "Form" you can overwrite the `jumpto` page
- in the content element or module "Form" you can overwrite the `recipient` for email notification
- in each form field you can add an optional help text (you have to customize the form field templates for the output)
- add custom error/success message before form (useful when no page redirect is defined)
- auto scroll to error element

## Customize template

To display the help texts, the templates of the form widgets must be adapted. The following output must be inserted there:

```php
<?= $this->hofff_formtools_help ?>
```

## Compatibility

- Contao version >= 4.4.0


## Dependency

There are no dependencies to other extensions, that have to be installed.
