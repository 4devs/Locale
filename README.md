Locale Library
==============
[![Build Status](https://secure.travis-ci.org/4devs/Locale.png?branch=master)](http://travis-ci.org/4devs/Locale)

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/7d6a1244-eb29-4d8a-8819-ffb7c8d71f4a/mini.png)](https://insight.sensiolabs.com/projects/7d6a1244-eb29-4d8a-8819-ffb7c8d71f4a)

Documentation
-------------

## Installation and usage

Installation and usage is a quick:

1. Download Locale using composer
2. Use the library
3. Customize Data Provider

You can "[fdevs/locale-bridge](https://packagist.org/packages/fdevs/locale-bridge)" for use with other libraries/components


### Step 1: Download Locale library using composer

Download the bundle by running the command:

``` bash
$ php composer.phar require fdevs/locale
```

Composer will install the bundle to your project's `vendor/fdevs` directory.


### Step 2: Use the library

####Basic setup:

```php
<?php

require DIR . '/../vendor/autoload.php';

use FDevs\Locale\Model\LocaleText;
use FDevs\Locale\Translator;

// The same text in different languages
$englishText = new LocaleText('I am a programmer', 'en');
$chineseText = new LocaleText('我是程序员', 'zh');
$russianText = new LocaleText('Я программист', 'ru');

$supportedTexts = [
    $englishText,
    $russianText,
    $chineseText,
];

$trans = new Translator();
```

####Set current locale:
```php
$trans->setLocale('zh');
```

####Get text for current locale:
```php
// 1. Get text for current locale - ch (Chinese)
$text = $trans->trans($supportedTexts);
echo $text?$text->getText():'';
// Output: "我是程序员"
```

####Get text for locale - ru:
```php
$text = $trans->trans($supportedTexts, 'ru');
echo $text?$text->getText():'';
// Output: "Я программист"
```

####Get text for a locale for which we don't have translation:
```php
$text = $trans->trans($supportedTexts, 'kk');
echo $text?$text->getText():'';
// Output: ""
```

####Get text using a set of prioritized locales:
Here you can treat this as locales fallback, first found locale from your list will be chosen.
```php
use FDevs\Locale\Model\PriorityLocale;
use FDevs\Locale\TranslatorPriority;

$priorityLocale = [
    new PriorityLocale('uk',['en','ru']),
    new PriorityLocale('en',['uk']),
    new PriorityLocale('fa',['zh','en']),
];

$trans = new TranslatorPriority('en',$priorityLocale);
$text = $trans->trans($supportedTexts, 'uk');
echo $text?$text->getText():'';
// Output: "I am programmer"
```


### Step 3: Customize Data Provider

#### create your awesome provider

```php
use FDevs\Locale\DataProvider\DataProviderInterface;

class MyProvider implements DataProviderInterface
{
//implement interface
}
```

#### add your provider

```php
use FDevs\Locale\DataProvider\DataProviderRegistry;
use FDevs\Locale\Translator;
use FDevs\Locale\TranslatorPriority;

$registry = new DataProviderRegistry([new MyProvider()]);
$translator = new Translator('en',$registry);
//or
$translator = new TranslatorPriority('en', $priorityLocale, $registry);

```

License
-------

This library is under the MIT license. See the complete license in the Library:

    LICENSE

Reporting an issue or a feature request
---------------------------------------

Issues and feature requests are tracked in the [Github issue tracker](https://github.com/4devs/locale/issues).
