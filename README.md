# Behat Drupal Translations
This extension to Behat and the Drupal extension enables the power of 
translate interface into your steps.

## Installation
Installation through composer:
```
composer require dazzle/behat-drupal-translations:dev-develop
```

## Usage
In your Behat config YAML file add following part in the 'extensions':
```
Dazzle\DrupalTranslations\Extension: ~
```

Syntax:
```
string|t
string#context|t
```

Example steps:
```
...
And I press the "Pay|t" button
Then I should see the heading "Payment confirmation|t"
Then I should see the error message "Payment amount should be greater that @amount|1.000|t"
When I click "My payments#payments|t"
Then I should see the heading "My payments|t"
...
```
In the background this extension will use the current language and 
lookup the translation.

## Credits
- Originally developed by [Olivier Jacquet](https://github.com/ojacquet) and [Kevin Thiels](https://github.com/Novitsh)

[www.dazzle.be](https://www.dazzle.be/?ref=github-drupal-translations)